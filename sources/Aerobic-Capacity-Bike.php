#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "Aerobic Capacity: Bike";
$url = "http://aerobiccapacity.com/";
$sel = "h3.mk-slider-title:6,div.mk-slider-description:6";

$out = array(
    'result' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD",
    'error' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD"
);

if ($sel != "") {
    $out = scrape::do_scrape($url, $sel, $title);
}

scrape::do_output($url, $title, $out);
