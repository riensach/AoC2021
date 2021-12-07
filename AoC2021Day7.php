<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-4);
$puzzleInput = require 'input/'.$fileName.'.php';


//$puzzleInput = "16,1,2,0,4,2,7,1,2,14";
$inputArray = explode(",",$puzzleInput);


$fuelUsed = array();
for ($position = 0; $position < 500; $position++) {
    $fuelTracker = 0;
    foreach($inputArray as $key => $moveValue) {
        $fuelTracker += abs($moveValue - $position);
    }
    $fuelUsed[$position] = $fuelTracker;
}

asort($fuelUsed);

$getPosition = array_key_first($fuelUsed);
$getFuelUsed = $fuelUsed[$getPosition];

echo "Day 7 Part A: Least fuel used was ".$getFuelUsed." at position $getPosition<br>";

$fuelUsed = array();
for ($position = 0; $position < 500; $position++) {
    $fuelTracker = 0;
    foreach($inputArray as $key => $moveValue) {
        $moves = abs($moveValue - $position);
        $fuelTracker += array_sum(range(1,$moves));
        //$fuelTracker += ($moves*($moves+1))/2;
    }
    $fuelUsed[$position] = $fuelTracker;

}

asort($fuelUsed);
$getPosition = array_key_first($fuelUsed);
$getFuelUsed = $fuelUsed[$getPosition];

echo "Day 7 Part B: Least fuel used was ".$getFuelUsed." at position $getPosition<br>";


$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";