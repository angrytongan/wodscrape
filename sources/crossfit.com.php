#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "crossfit.com";
$url = "https://www.crossfit.com/";
$sel = "div#wodsHome";

$out = array(
    'result' => "Not yet configured",
    'error' => "Not yet configured"
);

if ($sel != "") {
    $out = scrape::do_scrape($url, $sel, $title);
}

scrape::do_output($url, $title, $out);
