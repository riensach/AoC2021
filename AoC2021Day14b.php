<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-6);
$puzzleInput = require 'input/'.$fileName.'.php';

$puzzleInput = "NNCB

CH -> B
HH -> N
CB -> H
NH -> C
HB -> C
HC -> B
HN -> C
NN -> C
BH -> H
NC -> B
NB -> B
BN -> B
BB -> N
BC -> B
CC -> N
CN -> C";

$inputArray = explode("\n",$puzzleInput);

$polymer = '';
$pairInsertion = array();
foreach($inputArray as $key => $value) {
    if($key==0) {
        $chars = str_split($value,1);
        //foreach($chars as $key2 => $value2) {
            $polymer = $value;
        //}
    } elseif(strlen($value) > 2) {
        $chars = explode(" -> ",$value);
        $pairInsertion[$chars[0]] = $chars[1];
    }
}

function calculateScore($polymer){
    $charCount = array();
    $chars = str_split($polymer,1);
    foreach($chars as $key => $value) {
        if(isset($charCount[$value])) {
            $charCount[$value] = $charCount[$value] + 1;
        } else {
            $charCount[$value] = 1;
        }
    }

    sort($charCount);
    $firstKey = array_key_first($charCount);
    $lastKey = array_key_last($charCount);
    $calc =$charCount[$lastKey] - $charCount[$firstKey];
    return $calc;
}


$steps = 10;

for ($x = 0; $x < $steps; $x++) {

    $polymerSize = strlen($polymer);
    $tempPolymer = $polymer;
    $insertedCount = 0;
    for ($y = 0; $y < ($polymerSize-1); $y++) {
        $stringToAnalyse = substr($polymer, $y, 2);
        $stringToInsert = $pairInsertion[$stringToAnalyse];
        $tempPolymer = substr_replace($tempPolymer, $stringToInsert, ($y+1+$insertedCount), 0);
        $insertedCount++;
    }
    $polymerSizeEnd = strlen($tempPolymer);
    echo "After iteration $x the polymer has grown from $polymerSize to $polymerSizeEnd, and the number of variables is as follows:<br>";

    $charCount = array();
    $chars = str_split($polymer,1);
    foreach($chars as $key => $value) {
        if(isset($charCount[$value])) {
            $charCount[$value] = $charCount[$value] + 1;
        } else {
            $charCount[$value] = 1;
        }
    }

    //sort($charCount);
    var_dump($charCount);
    echo "<br>";






    $polymer = $tempPolymer;

    $time_post = microtime(true);
    $exec_time = $time_post - $time_pre;
    echo "Completed step $x in $exec_time seconds<br>";
    ob_flush();
    flush();
    if($x==9) {
        $partACalc = calculateScore($polymer);
    }

}


$steps = 30;

for ($x = 0; $x < $steps; $x++) {
}
}



$partBCalc = calculateScore($polymer);


echo "Day 14 Part A: Polymer calc ".$partACalc."<br>";
echo "Day 14 Part B: Polymer calc ".$partBCalc."<br>";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";