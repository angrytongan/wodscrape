#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "SOFLETE";
$url = "https://soflete.com/blogs/daily-work";
$sel = "article:first";

$out = array(
    'result' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD",
    'error' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD"
);

if ($sel != "") {
    $out = scrape::do_scrape($url, $sel, $title);
    $pattern = '<style.".*">';
    $out['result'] = preg_replace($pattern, '', $out['result'], 1);
}

scrape::do_output($url, $title, $out);
