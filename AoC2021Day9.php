<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-4);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "2199943210
//3987894921
//9856789892
//8767896789
//9899965678";

$inputArray = explode("\n",$puzzleInput);

$gridArray = array();
$gridSize = 100;
for ($x = 0; $x < $gridSize; $x++) {
    for ($y = 0; $y < $gridSize; $y++) {
        $gridArray[$x][$y] = '100';
    }
}

foreach($inputArray as $key => $value) {
    $inputValues = str_split($value,1);
    foreach($inputValues as $key2 => $value2) {
        $gridArray[$key][$key2] = $value2;
    }
}

function printGrid($trackGridInputArray) {
    echo "<code>";
    foreach($trackGridInputArray as $rowID => $rowColumn) {
        foreach ($rowColumn as $columnID => $gridData){
            if($gridData==" ") $gridData = "&nbsp;";
            echo "$gridData ";
        }
        echo "<br>";
    }
    echo "</code>";
}

//printGrid($gridArray);

$sumRisk = 0;
$lowPoints = array();
foreach($gridArray as $key => $value) {
    foreach($value as $key2 => $value2) {
        $valueAbove = $gridArray[$key-1][$key2] ?? 100;
        $valueBelow = $gridArray[$key+1][$key2] ?? 100;
        $valueLeft = $gridArray[$key][$key2+1] ?? 100;
        $valueRight = $gridArray[$key][$key2-1] ?? 100;

        if($value2 < $valueAbove && $value2 < $valueBelow && $value2 < $valueLeft && $value2 < $valueRight) {
            // Low point
            $lowPoints[] = "$key,$key2";
            $sumRisk += (1 + $value2);
        }
    }
}
$basins = array();
foreach($lowPoints as $key => $value) {
    $basinCount = 1;
    $getXY = explode(",",$value);
    $firstKey = $getXY[0];
    $secondKey = $getXY[1];
    $gridValue = $gridArray[$firstKey][$secondKey];
    $valuesCounted = array();
    $basinCount = checkAround($firstKey,$secondKey,$basinCount,$gridArray,$valuesCounted);
    $basins[] = $basinCount;
}

function checkAround($firstKey,$secondKey,$basinCount,&$gridArray,&$valuesCounted) {

    $gridValue = $gridArray[$firstKey][$secondKey];
    $valueAbove = $gridArray[$firstKey-1][$secondKey] ?? 100;
    $valueBelow = $gridArray[$firstKey+1][$secondKey] ?? 100;
    $valueLeft = $gridArray[$firstKey][$secondKey+1] ?? 100;
    $valueRight = $gridArray[$firstKey][$secondKey-1] ?? 100;

    if($valueAbove > $gridValue && $valueAbove < 9 && !isset($valuesCounted[$firstKey-1][$secondKey])) {
        $basinCount++;
        $valuesCounted[$firstKey-1][$secondKey] = "X";
        $basinCount = checkAround($firstKey-1,$secondKey,$basinCount,$gridArray,$valuesCounted);
    }
    if($valueBelow > $gridValue && $valueBelow < 9 && !isset($valuesCounted[$firstKey+1][$secondKey])) {
        $basinCount++;
        $valuesCounted[$firstKey+1][$secondKey] = "X";
        $basinCount = checkAround($firstKey+1,$secondKey,$basinCount,$gridArray,$valuesCounted);
    }
    if($valueLeft > $gridValue && $valueLeft < 9 && !isset($valuesCounted[$firstKey][$secondKey+1])) {
        $basinCount++;
        $valuesCounted[$firstKey][$secondKey+1] = "X";
        $basinCount = checkAround($firstKey,$secondKey+1,$basinCount,$gridArray,$valuesCounted);
    }
    if($valueRight > $gridValue && $valueRight < 9 && !isset($valuesCounted[$firstKey][$secondKey-1])) {
        $basinCount++;
        $valuesCounted[$firstKey][$secondKey-1] = "X";
        $basinCount = checkAround($firstKey,$secondKey-1,$basinCount,$gridArray,$valuesCounted);
    }

    return  $basinCount;
}

rsort($basins);

$sumBasin = 0;
$sumBasinValue1 = $basins[0];
$sumBasinValue2 = $basins[1];
$sumBasinValue3 = $basins[2];

$sumBasin = $sumBasinValue1 * $sumBasinValue2 * $sumBasinValue3;

echo "Day 9 Part A: Low point risk total was ".$sumRisk."<br>";
echo "Day 9 Part B: Basin calculation was ".$sumBasin."<br>";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";