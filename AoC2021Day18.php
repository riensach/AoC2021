<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';

$puzzleInput = "[1,2]
[[1,2],3]
[9,[8,7]]
[[1,9],[8,5]]
[[[[1,2],[3,4]],[[5,6],[7,8]]],9]
[[[9,[3,8]],[[0,9],6]],[[[3,7],[4,9]],3]]
[[[[1,3],[5,3]],[[1,3],[8,7]]],[[[4,9],[6,9]],[[8,2],[7,3]]]]";

$inputArray = explode("\n",$puzzleInput);

$strPos = 0;
$treeArray = array();
foreach($inputArray as $key => $value) {
    $strPos = 0;
    $depth = 0;
    $charValues = str_split($value, 1);
    $treeArray[$key] = array();
    foreach($charValues as $key2 => $value2) {
        if($value2 == '[') {
            $depth++;
        } elseif($value2 == ']') {
            $depth--;
        }
    }
}


echo "Day 16 Part A: Summary of version numbers ".$versionNumbers."<br><br>";


$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";