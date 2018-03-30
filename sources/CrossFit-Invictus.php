#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "CrossFit Invictus";
$url = "https://www.crossfitinvictus.com/blog/";
$sel = "section.wod_widget";

$out = array(
    'result' => "Not yet configured",
    'error' => "Not yet configured"
);

if ($sel != "") {
    $out = scrape::do_scrape($url, $sel, $title);
}

scrape::do_output($url, $title, $out);
