#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "Hybrid Athletics: CrossFit WOD";
$url = "http://www.hybridathletics.com/crossfitwod/";
//$sel = "hi.entry-title:first, div.post:first p:first";
$sel = "header:first span.article-dateline, div.post:first p";

$out = array(
    'result' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD",
    'error' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD"
);

if ($sel != "") {
    $out = scrape::do_scrape($url, $sel, $title);
}

scrape::do_output($url, $title, $out);
