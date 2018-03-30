.PHONY: deploy production index

PRODUCTION=production
DESTBUCKET=wherever.you.deploy.to.com
GZIP_HEADER=--add-header="Content-Encoding:gzip"
CACHE_HEADER=--add-header="Cache-Control:max-age=3600"

SRCS := $(wildcard ./sources/*.php)
TARGETS := $(patsubst ./sources/%.php,./production/%.html,$(SRCS))

./production/%.html: ./sources/%.php
	./$< > $@

help:
	@echo "make index:      create index.html in $(PRODUCTION)/"
	@echo "make scrape:     create production website in $(PRODUCTION)/"
	@echo "make deploy:     compress production website and deploy to $(DESTBUCKET)"
	@echo "make clean:      remove $(PRODUCTION)/"
	@echo "make lastsources SINCE=<datestamp>: show last source additions since <datestamp>"

scrape: clean index
	make -j2 scrape-sites

scrape-sites: $(TARGETS)

index:
	@mkdir -p $(PRODUCTION)
	./construct-index.sh sources $(PRODUCTION)
	@cp sources/zepto.min.js $(PRODUCTION)
	@cp sources/app.js $(PRODUCTION)
	@cp sources/awesomplete.css $(PRODUCTION)
	@cp sources/awesomplete.css.map $(PRODUCTION)
	@cp sources/awesomplete.min.js $(PRODUCTION)
	@cp sources/awesomplete.min.js.map $(PRODUCTION)
	@cp sources/favicon.ico $(PRODUCTION)
	@cp sources/style.css $(PRODUCTION)

deploy: scrape
	@./add-analytics.sh $(PRODUCTION)
	@./add-adsense.sh $(PRODUCTION)
	@./do-gzip.sh $(PRODUCTION)
	s3cmd --rr sync --exclude '*' --include '*.css' --mime-type="text/css" $(GZIP_HEADER) $(PRODUCTION)/ s3://$(DESTBUCKET)
	s3cmd --rr sync --exclude '*' --include '*.html' --mime-type="text/html" $(GZIP_HEADER) $(CACHE_HEADER) $(PRODUCTION)/ s3://$(DESTBUCKET)
	s3cmd --rr sync --exclude '*' --include '*.js' --mime-type="application/javascript" $(GZIP_HEADER) $(PRODUCTION)/ s3://$(DESTBUCKET)
	s3cmd sync --delete-removed $(PRODUCTION)/ s3://$(DESTBUCKET)

clean:
	@/bin/rm -rf $(PRODUCTION)

lastsources:
	@echo ""
	@git log --since="$(SINCE)" --name-status|grep "^A.*sources/[A-Za-z0-9]"|sort|sed -e 's/^A.*sources\///g' -e 's/-/ /g' -e 's/\.php//g' -e 's/^/- Added /g'
	@git log --since="$(SINCE)" --name-status|grep "^D.*sources/[A-Za-z0-9]"|sort|sed -e 's/^D.*sources\///g' -e 's/-/ /g' -e 's/\.php//g' -e 's/^/- Removed /g'
	@echo ""
