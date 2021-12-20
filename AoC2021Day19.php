<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';

$puzzleInput = "D2FE28";

$inputArray = explode("\n",$puzzleInput);


foreach($inputArray as $key => $value) {

}


echo "Day 16 Part A: Summary of version numbers ".$versionNumbers."<br><br>";


$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";