# wodscrape

Set of scripts that create a single page website consisting of multiple different WODs (Workout Of the Day) from a number of different public sites.

See [wodscrape.com.au](http://www.wodscrape.com.au) for the production site.

## How it works

* `index.html` is created from a template + all sources that are available in `sources/`.
* Each `.php` file in `sources/` is an individual scraper that accesses it's specified website, scrapes the WOD and spits out a block of HTML.
* Each scraped block is placed into it's own individual file in the production directory.
* All files in production directory are compressed then pushed to an s3 bucket.
* On load, AJAX requests are used to load individual WODs.
* Loaded WODs are kept in a never-expire cookie on the client to maintain state between loads.
* Stats provided through Google Analytics.

In production this is run from [cron(8)](https://linux.die.net/man/8/cron) three times a day to cover a full day across the globe.

## Requirements

* Unix-like tools (sed, make, git)
* [php](https://www.php.net)
* [s3cmd](http://s3tools.org/s3cmd)

## Uses

* [hquery](https://duzun.github.io/hQuery.php)
* [Zepto.js](http://zeptojs.com/)

## Required for deploy

* `Makefile`: requires DESTBUCKET
* `sources/adsense-index.html`: requires adsense identifier
* `sources/analytics-app.js`: requires analytics identifier
* `sources/analytics-index.html`: requires analytics identifier
* [S3](https://aws.amazon.com/s3/) bucket configured as website
* Appropriately setup [s3cmd](http://s3tools.org/s3cmd) configuration

## Usage

* `make scrape` to create the index, scrape all sources and create production directory
* `make deploy` to scrape and push to an S3 bucket

## Adding new sources

* Add the new source to a `.csv` file 
  * First field is name of source
  * Second field is URL to scrape
* Run `util/gen-sources.sh` against the csv to generate one scraper per .csv line, which are placed into `sources/`.
* Edit each new source file and adjust the selector to pick the right portion of the page.

## Shortcomings

* Needs a rewrite.
* Each scraper is generated from the same template. For sites that require a couple of clicks to get to the WOD or something custom, the default template is lacking.
* Doesn't handle sites that generate their content over AJAX (ie. react sites).

## Licence

* Let's go with [MIT](https://en.wikipedia.org/wiki/MIT_License).
