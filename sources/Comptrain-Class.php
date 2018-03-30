#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "Comptrain Class";
$url = "http://comptrain.co/class/programming/";
$sel = "div.wpb_wrapper:first";

$out = array(
    'result' => "Not yet configured",
    'error' => "Not yet configured"
);

if ($sel != "") {
    $out = scrape::do_scrape($url, $sel, $title);
}

scrape::do_output($url, $title, $out);
