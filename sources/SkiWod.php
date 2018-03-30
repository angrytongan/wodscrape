#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "SkiWod";
$url = "https://skiwod.co/";
$sel = "article:first";

$out = array(
    'result' => "Not yet configured",
    'error' => "Not yet configured"
);

if ($sel != "") {
    $out = scrape::do_scrape($url, $sel, $title);
}

scrape::do_output($url, $title, $out);
