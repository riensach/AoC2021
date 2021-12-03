<?php

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

$time_pre = microtime(true);

$inputArray = explode("\n",$puzzleInput);

$gammaRate = 0;
$epsilonRate = 0;

$dataLog = array();

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

    foreach ($value as $key2 => $value2) {

        if($value2==0){
            $value0++;
        } else {
            $value1++;
        }

    }

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

$valueA = $trueGamma * $trueEpsilon;

echo "Day 3 Part A: ".$valueA."<br>";




$oxygenInputArray = $inputArray;
$inputCheckPosition = 0;

while(count($oxygenInputArray) > 1) {

    $value0 = 0;
    $value1 = 0;
    $mostCommon = 0;

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
            //echo "Removing values at position $inputCheckPosition not with $mostCommon :: $count<br>";
            unset($oxygenInputArray[$key]);
        }
    }
    $inputCheckPosition++;

    if($inputCheckPosition>=strlen(current($oxygenInputArray))) {
        $inputCheckPosition = 0;
    }


}


$oxygenRating = current($oxygenInputArray);








$co2InputArray = $inputArray;
$inputCheckPosition = 0;

while(count($co2InputArray) > 1) {

    $value0 = 0;
    $value1 = 0;
    $mostCommon = 0;

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
            //echo "Removing values at position $inputCheckPosition not with $mostCommon :: $count<br>";
            unset($co2InputArray[$key]);
        }
    }
    $inputCheckPosition++;

    if($inputCheckPosition>=strlen(current($co2InputArray))) {
        $inputCheckPosition = 0;
    }


}

$co2Rating = current($co2InputArray);

$trueOxygenRating = bindec($oxygenRating);
$trueCo2Rating = bindec($co2Rating);
$lifeSupportRating = $trueOxygenRating * $trueCo2Rating;

echo "Day 3 Part B: ".$lifeSupportRating."<br>";



$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";
