#!/usr/bin/php
<?php

require_once("./lib/scrape.php");
require_once("./lib/Requests.php");

Requests::register_autoloader();

$title = "FittIST Training";
$url = "http://www.fittisttraining.com/";
$sel = "article:0";

$out = array(
    'result' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD",
    'error' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD"
);

$response = Requests::get($url);
if ($response->success) {
    $out = scrape::do_scrape($url, $sel, $title, $response->body);
}

scrape::do_output($url, $title, $out);
