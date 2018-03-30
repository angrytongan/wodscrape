#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "CrossFit Mayhem";
$url = "http://www.crossfitmayhem.com/";
$sel = "article:first";

$out = scrape::do_scrape($url, $sel, $title);
scrape::do_output($url, $title, $out);
