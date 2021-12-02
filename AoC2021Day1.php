<?php

$fileName = substr(basename(__FILE__, '.php'),-4);
$puzzleInput = require 'input/'.$fileName.'.php';

$time_pre = microtime(true);

$inputArray = explode("\n",$puzzleInput);
$previousOceanFloorValue = 0;
$increaseCount = 0;
foreach($inputArray as $key => $oceanFloorValue) {
    if($key > 0 && $oceanFloorValue > $previousOceanFloorValue) {
        $increaseCount++;
    }
    $previousOceanFloorValue = $oceanFloorValue;

}



$oceanFloorValues = new \Ds\Deque();
$increaseCountPartB = 0;
foreach($inputArray as $key => $oceanFloorValue) {

    $oceanFloorValues->push($oceanFloorValue);
    if($key > 2) {
        // logic here
        $firstWindow = $oceanFloorValues->get(0) + $oceanFloorValues->get(1) + $oceanFloorValues->get(2);
        $secondWindow = $oceanFloorValues->get(1) + $oceanFloorValues->get(2) + $oceanFloorValues->get(3);

        if($secondWindow > $firstWindow) {
            $increaseCountPartB++;
        }

    }

    if($key > 2) {
        $oceanFloorValues->shift();
    }

}


echo "Day 1 Part A: ".$increaseCount."<br>";
echo "Day 1 Part B: ".$increaseCountPartB."<br>";


$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";








