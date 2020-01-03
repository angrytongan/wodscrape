s/^ *<tr>//g
s/^ *<\/tr>//g
s/" target="_blank">/ /g
s/^.*href="//g
s/<\/a><\/td>//g
s/ *<td.*\/td>$//g
/^$/d
s/\([^ ]*\) \(.*$\)/\2,\1/g

#http://www.crossfitnz.co.nz/ CrossFit New Zealand (NZ)
#http://www.madcrossfit.com MaD CrossFit
#http://crossfitchristchurch.com/ CrossFit Christchurch
#http://www.crossfitbirkenhead.com CrossFit Birkenhead
#http://www.crossfithawkesbay.co.nz CrossFit Hawkes Bay
#http://www.rapidcrossfit.co.nz Rapid CrossFit
#http://crossfitnewmarket.co.nz/ CrossFit Newmarket
#http://crossfitmana.com/ CrossFit Mana
#http://www.crossfitinfinite.com CrossFit Infinite Takapuna
#http://crossfitdunedin.co.nz/ CrossFit Dunedin
