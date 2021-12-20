<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-6);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "..#.#..#####.#.#.#.###.##.....###.##.#..###.####..#####..#....#..#..##..###..######.###...####..#..#####..##..#.#####...##.#.#..#.##..#.#......#.###.######.###.####...#.##.##..#..#..#####.....#.#....###..#.##......#.....#..#..#..##..#...##.######.####.####.#.#...#.......#..#.#.#...####.##.#......#..#...##.#.##..#...##.#.##..###.#......#.#.......#.#.#.####.###.##...#.....####.#..#..#.##.#....##..#.####....##...##..#...#......#.#.......#.......##..####..#...#.#.#...##..#.#..###..#####........#..####......#..#
//
//#..#.
//#....
//##..#
//..#..
//..###";

$inputArray = explode("\n",$puzzleInput);
$infoArray = array();

$infoArray = array();
$gridMinWidth = -60;
$gridMinLength = -60;
$gridMaxWidth = 200;
$gridMaxLength = 200;
for ($x = $gridMinWidth; $x <= $gridMaxWidth; $x++) {
    for ($y = $gridMinLength; $y <= $gridMaxLength; $y++) {
        $infoArray[$x][$y] = '.';
    }
}


foreach($inputArray as $key => $value) {

    if($key==0) {
        $imageAlgorithm = $value;
    } elseif($value <> "") {
        $chars = str_split($value,1);
        foreach($chars as $key2 => $value2) {
            $infoArray[$key][$key2] = $value2;
        }
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

printGrid($infoArray);

$maxSteps = 50;
for ($x = 0; $x < $maxSteps; $x++) {
    $tempArray = $infoArray;

    foreach($infoArray as $key => $value) {
        foreach($value as $key2 => $value2) {

            $stringValue1 = $infoArray[$key-1][$key2-1] ?? '.';
            $stringValue2 = $infoArray[$key-1][$key2] ?? '.';
            $stringValue3 = $infoArray[$key-1][$key2+1] ?? '.';
            $stringValue4 = $infoArray[$key][$key2-1] ?? '.';
            $stringValue5 = $infoArray[$key][$key2] ?? '.';
            $stringValue6 = $infoArray[$key][$key2+1] ?? '.';
            $stringValue7 = $infoArray[$key+1][$key2-1] ?? '.';
            $stringValue8 = $infoArray[$key+1][$key2] ?? '.';
            $stringValue9 = $infoArray[$key+1][$key2+1] ?? '.';

            $string = $stringValue1.$stringValue2.$stringValue3.$stringValue4.$stringValue5.$stringValue6.$stringValue7.$stringValue8.$stringValue9;
            //echo "String value: $string<br>";

            $binString = str_replace( '.', 0, $string);
            $binString = str_replace( '#', 1, $binString);
            //echo "Decimal seed value: $binString<br>";
            $binString = bindec($binString);
            //echo "Decimal value: $binString<br>";
            $getStringValue = $imageAlgorithm[$binString];
            //echo "New string value: $getStringValue<br>";
            $tempArray[$key][$key2] = $getStringValue;

            if($key==$gridMinWidth && $x % 2 == 1) {
                $tempArray[$key][$key2] = '.';
            }
            if($key2==$gridMaxLength && $x % 2 == 1) {
                $tempArray[$key][$key2] = '.';
            }
            if($key2==$gridMinWidth && $key==$gridMaxLength && $x % 2 == 1) {
                $tempArray[$key][$key2] = '.';
            }
        }
    }


    $infoArray = $tempArray;
    //echo "<br><Br>";
    //printGrid($infoArray);
}

foreach($infoArray as $key => $value) {
    foreach ($value as $key2 => $value2) {
        if($key==-60) {
           // $infoArray[$key][$key2] = '.';
        }
        if($key2==200) {
            //$infoArray[$key][$key2] = '.';
        }
    }
}

echo "<br><Br>";
printGrid($infoArray);


$lightPixels = 0;
foreach($infoArray as $key => $value) {
    foreach($value as $key2 => $value2) {
        if($value2 == '#') {
            $lightPixels++;
        }
    }
}


echo "Day 20 Part A: Total lit pixels ".$lightPixels."<br><br>";


$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";