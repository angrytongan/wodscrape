#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "CrossFit Linchpin";
$url = "https://www.crossfitlinchpin.com/pages/workout-of-the-day";
$sel = "div.two-thirds";

$out = scrape::do_scrape($url, $sel, $title);
scrape::do_output($url, $title, $out);
