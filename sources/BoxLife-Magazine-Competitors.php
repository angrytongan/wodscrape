#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "BoxLife Magazine: Competitor";
$url = "http://boxlifemagazine.com/category/workouts-competitors/";
$sel = "h3.entry-title:first a";

$out = array(
    'result' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD",
    'error' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD"
);

$out = scrape::do_scrape($url, $sel, $title);
if ($out['result']) {
    preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $out['result'], $result);

    if (!empty($result)) {
        $url = $result['href'][0];
        $sel = "div.td-post-content:first p";
        $out = scrape::do_scrape($url, $sel, $title);
    }
}
scrape::do_output($url, $title, $out);
