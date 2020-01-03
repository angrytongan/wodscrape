#!/usr/bin/php
<?php

require_once("./lib/scrape.php");
require_once("./lib/Requests.php");

Requests::register_autoloader();

$title = "crossfit.com";
$url = "https://www.crossfit.com/workout/";
$sel = "section#archives:first div.row:1 div:1";

$out = array(
    'result' => "Not yet configured",
    'error' => "Not yet configured"
);

$response = Requests::get($url);
if ($sel != "") {
    $out = scrape::do_scrape($url, $sel, $title, $response->body);
}

scrape::do_output($url, $title, $out);
