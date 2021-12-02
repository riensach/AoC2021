<?php

$fileName = substr(basename(__FILE__, '.php'),-4);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "forward 5
//down 5
//forward 8
//up 3
//down 8
//forward 2";

$time_pre = microtime(true);

$inputArray = explode("\n",$puzzleInput);

$depth = 0;
$horizontalPosition = 0;
$aim = 0;

foreach($inputArray as $key => $value) {

    $valueParts = explode(' ',$value);
    $action = $valueParts[0];
    $movementNumber = $valueParts[1];

    if($action=='forward') {
        $horizontalPosition = $horizontalPosition + $movementNumber;
        $depth = $depth + ($aim * $movementNumber);

    } elseif($action=='up') {
        $aim = $aim - $movementNumber;

    } elseif($action=='down') {
        $aim = $aim + $movementNumber;

    }

}

$valueA = $aim * $horizontalPosition;
$valueB = $depth * $horizontalPosition;

echo "Day 1 Part A: ".$valueA."<br>";
echo "Day 1 Part B: ".$valueB."<br>";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";