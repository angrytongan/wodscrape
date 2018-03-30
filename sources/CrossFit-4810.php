#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "CrossFit 4810";
$url = "http://www.crossfit4810.com.au/category/wod/";
$sel = "div.post:first h2 a";

$out = array(
    'result' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD",
    'error' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD"
);

$out = scrape::do_scrape($url, $sel, $title);
if ($out['result']) {
    preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $out['result'], $result);

    if (!empty($result)) {
        $url = $result['href'][0];
        $sel = "div.post:first";
        $out = scrape::do_scrape($url, $sel, $title);
    }
}
scrape::do_output($url, $title, $out);
