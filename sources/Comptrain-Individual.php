#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "Comptrain Individual";
$url = "http://comptrain.co/individuals/home";
$sel = "div.post-content:first > div.vc_row";

$out = array(
    'result' => "Not yet configured",
    'error' => "Not yet configured"
);

if ($sel != "") {
    $out = scrape::do_scrape($url, $sel, $title);
}

scrape::do_output($url, $title, $out);
