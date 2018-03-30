#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "CrossFit Dungeon";
$url = "http://crossfitdungeon.com/blog/w-o-d/";
$sel = "article:first div.thePost a";

$out = array(
    'result' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD",
    'error' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD"
);

$out = scrape::do_scrape($url, $sel, $title);
if ($out['result']) {
    preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $out['result'], $result);

    if (!empty($result)) {
        $url = $result['href'][0];
        $sel = "article:first div.thePost";
        $out = scrape::do_scrape($url, $sel, $title);
    }
}

scrape::do_output($url, $title, $out);
