#!/usr/bin/php
<?php

require_once("./lib/scrape.php");

$title = "Concept2 SkiErg";
$url = "http://www.concept2.com/skierg/training/wod";
$sel = "section#wod-short,section#wod-medium,section#wod-long";

$out = scrape::do_scrape($url, $sel, $title);
scrape::do_output($url, $title, $out);
