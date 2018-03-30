#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "Atlas Strong";
$url = "https://www.atlasstrongtraining.com/";
$sel = "article:0 h1, article:0 .author-date, article:0 .body";

$out = array(
    'result' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD",
    'error' => "Not yet configured - <a href=\"https://www.reddit.com/user/angrytongan\" target=\"_blank\">contact me</a> to add this WOD"
);

if ($sel != "") {
    $out = scrape::do_scrape($url, $sel, $title);
}

scrape::do_output($url, $title, $out);
