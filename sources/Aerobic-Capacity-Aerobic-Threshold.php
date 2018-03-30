#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "Aerobic Capacity: Aerobic Threshold";
$url = "http://aerobiccapacity.com/";
$sel = "div.mk-slider-title:0,div.mk-slider-description:0";

$out = array(
    'result' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD",
    'error' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD"
);

if ($sel != "") {
    $out = scrape::do_scrape($url, $sel, $title);
}

scrape::do_output($url, $title, $out);
