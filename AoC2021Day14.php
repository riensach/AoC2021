<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';

$puzzleInput = "";

$inputArray = explode("\n",$puzzleInput);


foreach($inputArray as $key => $value) {

}



echo "Day 14 Part A: Total points are ".$pointsTotal."<br>";
echo "Day 14 Part B: Middle score is ".$middleScore."<br>";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";