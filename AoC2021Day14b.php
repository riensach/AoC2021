<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-6);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "NNCB
//
//CH -> B
//HH -> N
//CB -> H
//NH -> C
//HB -> C
//HC -> B
//HN -> C
//NN -> C
//BH -> H
//NC -> B
//NB -> B
//BN -> B
//BB -> N
//BC -> B
//CC -> N
//CN -> C";

$inputArray = explode("\n",$puzzleInput);

$polymer = '';
$pairInsertion = array();
$polymerPairs = array();
foreach($inputArray as $key => $value) {
    if($key==0) {
        $chars = str_split($value,1);
        foreach($chars as $key2 => $value2) {
            if(!isset($chars[$key2+1])) {

            } elseif(isset($polymerPairs[$value2.$chars[$key2+1]])) {
                $polymerPairs[$value2.$chars[$key2+1]] = $polymerPairs[$value2.$chars[$key2+1]] + 1;
            } else {
                $polymerPairs[$value2.$chars[$key2+1]] = 1;
            }
            $polymer = $value;
        }
    } elseif(strlen($value) > 2) {
        $chars = explode(" -> ",$value);
        $pairInsertion[$chars[0]] = $chars[1];
    }
}

//var_dump($polymerPairs);

$steps = 40;



for ($x = 0; $x < $steps; $x++) {

    $tempPolymerPairs = array();
    foreach($polymerPairs as $key => $value) {
        //$tempPolymerPairs[$key] = 0;
        $stringToInsert = $pairInsertion[$key];
        $polymerSplit = str_split($key,1);
        //var_dump($polymerSplit);
        //echo "$stringToInsert<br>";
        if(!isset($tempPolymerPairs[$polymerSplit[0].$stringToInsert])) {
            $tempPolymerPairs[$polymerSplit[0].$stringToInsert] = 0;
        }
        $tempPolymerPairs[$polymerSplit[0].$stringToInsert] += $value;
        //echo $polymerSplit[0].$stringToInsert . " - " .$tempPolymerPairs[$polymerSplit[0].$stringToInsert]."<br>";
        if(!isset($tempPolymerPairs[$stringToInsert.$polymerSplit[1]])) {
            $tempPolymerPairs[$stringToInsert.$polymerSplit[1]] = 0;
        }
        $tempPolymerPairs[$stringToInsert.$polymerSplit[1]] += $value;
        //echo $stringToInsert.$polymerSplit[1] . " - " .$tempPolymerPairs[$stringToInsert.$polymerSplit[1]]."<br>";
    }
    //echo "<Br><br><br>";

    $polymerPairs = $tempPolymerPairs;
    //var_dump($polymerPairs);
    //echo $polymer."<br>";

    $time_post = microtime(true);
    $exec_time = $time_post - $time_pre;
    echo "Completed step $x in $exec_time seconds<br>";
    ob_flush();
    flush();
}

$charCount = array();
foreach($polymerPairs as $key => $value) {


    $polymerSplit = str_split($key,1);
    if(!isset($charCount[$polymerSplit[0]])){
        $charCount[$polymerSplit[0]] = $value;
    } else {
        $charCount[$polymerSplit[0]] += $value;
    }

    if(!isset($charCount[$polymerSplit[1]])){
        $charCount[$polymerSplit[1]] = $value;
    } else {
        $charCount[$polymerSplit[1]] += $value;
    }


}



sort($charCount);
var_dump($charCount);
$firstKey = array_key_first($charCount);
$lastKey = array_key_last($charCount);

$calc =($charCount[$lastKey]/2) - ($charCount[$firstKey]/2);




echo "Day 14 Part A: Total points are ".$calc."<br>";
echo "Day 14 Part B: Middle score is ".$middleScore."<br>";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";