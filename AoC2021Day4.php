<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-4);
$puzzleInput = require 'input/'.$fileName.'.php';

$puzzleInput = "00100
11110
10110
10111
10101
01111
00111
11100
10000
11001
00010
01010";

$inputArray = explode("\n",$puzzleInput);






















echo "Day 4 Part A: ".$lifeSupportRating."<br>";
echo "Day 4 Part B: ".$lifeSupportRating."<br>";



$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";
