#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "Wheel WOD";
$url = "http://wheelwod.com/";
$sel = "article:0 a:0";

$out = array(
    'result' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD",
    'error' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD"
);

$out = scrape::do_scrape($url, $sel, $title);
if ($out['result']) {
    preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $out['result'], $result);

    if (!empty($result)) {
        $url = $result['href'][0];
        $sel = "article:0 div.entry-content";
        $out = scrape::do_scrape($url, $sel, $title);
    }
}
scrape::do_output($url, $title, $out);
