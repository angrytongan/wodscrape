#!/usr/bin/php
<?php

require_once("./lib/scrape.php");
require_once("./lib/Requests.php");

Requests::register_autoloader();

$title = "Comptrain Individual";
$url = "https://comptrain.co/individuals/programming/";
/*$sel = "div.vc_grid-item-mini:first";*/
$sel = "div.vc_gitem-zone:1";

$out = array(
    'result' => "Not yet configured",
    'error' => "Not yet configured"
);

$response = Requests::get($url);
if ($response->success) {
    $out = scrape::do_scrape($url, $sel, $title, $response->body);
}

scrape::do_output($url, $title, $out);
