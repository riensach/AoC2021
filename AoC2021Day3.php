<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-4);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "00100
//11110
//10110
//10111
//10101
//01111
//00111
//11100
//10000
//11001
//00010
//01010";

$inputArray = explode("\n",$puzzleInput);

$gammaRate = 0;
$epsilonRate = 0;
$dataLog = array();

// This section splits the input into an array that has all the first bits, all the second bits etc
foreach($inputArray as $key => $value) {

    $valueBits = str_split($value);
    foreach ($valueBits as $key2 => $value2) {

        $dataLog[$key2][] = $value2;

    }
}

$gammaRate = '';
$epsilonRate = '';

foreach($dataLog as $key => $value) {
    $value0 = 0;
    $value1 = 0;
    // Here we identify the most popular bit per position
    foreach ($value as $key2 => $value2) {
        if($value2==0){
            $value0++;
        } else {
            $value1++;
        }
    }

    // Here we confirm the most and least popular bit per position
    if($value0 > $value1) {
        $gammaRate[$key] = 0;
        $epsilonRate[$key] = 1;
    } else {
        $gammaRate[$key] = 1;
        $epsilonRate[$key] = 0;
    }

}

$trueGamma = bindec($gammaRate);
$trueEpsilon = bindec($epsilonRate);
$powerConsumption = $trueGamma * $trueEpsilon;

echo "Day 3 Part A: ".$powerConsumption."<br>";

$oxygenInputArray = $inputArray;
$inputCheckPosition = 0; // Setting the variable to be used to identify why position we're evaluating
$mostCommon = 0; // Setting the variable to be used for the identification of the most common bit at any given position

while(count($oxygenInputArray) > 1) {
    $value0 = 0;
    $value1 = 0;
    foreach ($oxygenInputArray as $key => $value) {
        if($value[$inputCheckPosition]==0){
            $value0++;
        } else {
            $value1++;
        }
    }

    if($value0 > $value1) {
        $mostCommon = 0;
    } else {
        $mostCommon = 1;
    }

    foreach ($oxygenInputArray as $key => $value) {
        if($value[$inputCheckPosition]<>$mostCommon){
            $count = count($oxygenInputArray);
            unset($oxygenInputArray[$key]);
        }
    }
    $inputCheckPosition++;

}

// At this point we only have one left, so that's the value we need to use for the Oxygen Rating
$oxygenRating = current($oxygenInputArray);

$co2InputArray = $inputArray;
$inputCheckPosition = 0; // Setting the variable to be used to identify why position we're evaluating

while(count($co2InputArray) > 1) {
    $value0 = 0;
    $value1 = 0;
    foreach ($co2InputArray as $key => $value) {
        if($value[$inputCheckPosition]==0){
            $value0++;
        } else {
            $value1++;
        }
    }

    if($value0 > $value1) {
        $mostCommon = 0;
    } else {
        $mostCommon = 1;
    }

    foreach ($co2InputArray as $key => $value) {
        if($value[$inputCheckPosition]==$mostCommon){
            $count = count($co2InputArray);
            unset($co2InputArray[$key]);
        }
    }
    $inputCheckPosition++;

}

// At this point we only have one left, so that's the value we need to use for the Co2 Rating
$co2Rating = current($co2InputArray);

$trueOxygenRating = bindec($oxygenRating);
$trueCo2Rating = bindec($co2Rating);
$lifeSupportRating = $trueOxygenRating * $trueCo2Rating;

echo "Day 3 Part B: ".$lifeSupportRating."<br>";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";