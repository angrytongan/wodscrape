#!/usr/bin/php
<?php

require_once("./lib/scrape.php");
require_once("./lib/Requests.php");

Requests::register_autoloader();

$title = "Burgener Strength Performance";
$url = "https://www.burgenerstrength.com/performance";
$sel = "article:first";

$out = array(
    'result' => "Not yet configured",
    'error' => "Not yet configured"
);

$response = Requests::get($url);
if ($response->success) {
    $out = scrape::do_scrape($url, $sel, $title, $response->body);
}

scrape::do_output($url, $title, $out);
