#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "CrossFit Weightlifting";
$url = "http://crossfitweightlifting.com/category/wod/weightlifter/";
$sel = "article.post:first";

$out = array(
    'result' => "Not yet configured",
    'error' => "Not yet configured"
);

if ($sel != "") {
    $out = scrape::do_scrape($url, $sel, $title);
}

scrape::do_output($url, $title, $out);
