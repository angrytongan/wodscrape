#!/usr/bin/php
<?php

require_once("./lib/scrape.php");
require_once("./lib/Requests.php");

Requests::register_autoloader();

$title = "Hybrid Athletics: Strongman WOD";
$url = "http://www.hybridathletics.com/strongmanwod/";
$sel = "div.post:first";

$out = array(
    'result' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD",
    'error' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD"
);

$response = Requests::get($url);
if ($sel != "") {
    $out = scrape::do_scrape($url, $sel, $title, $response->body);
}

scrape::do_output($url, $title, $out);
