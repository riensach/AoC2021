<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';
//
//$puzzleInput = "6,10
//0,14
//9,10
//0,3
//10,4
//4,11
//6,0
//6,12
//4,1
//0,13
//10,12
//3,4
//3,0
//8,4
//1,10
//2,14
//8,10
//9,0
//
//fold along y=7
//fold along x=5";

$inputArray = explode("\n",$puzzleInput);

$folds = array();
$dots = array();


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

$maxlen = 0;
$maxwidth = 0;
foreach($inputArray as $key => $value) {
    $val = substr($value,0, 4);
    $len = strlen($value);
    if($val=='fold') {
        $foldValue = substr($value,11);
        $folds[] = $foldValue;
    } elseif($len>0) {
        $dots[] = $value;
        $coords = explode(",",$value);
        if($coords[0] > $maxlen) {
            $maxlen = $coords[0];
        }
        if($coords[1] > $maxwidth) {
            $maxwidth = $coords[1];
        }
    }
}

$gridArray = array();
$gridWidth = $maxwidth;
$gridLength = $maxlen;
for ($x = 0; $x <= $gridWidth; $x++) {
    for ($y = 0; $y <= $gridLength; $y++) {
        $gridArray[$x][$y] = '.';
    }
}

//printGrid($gridArray);

//var_dump($folds);
//var_dump($dots);

foreach($dots as $key => $value) {
    $coords = explode(",",$value);
    $gridArray[$coords[1]][$coords[0]] = '#';
}

//printGrid($gridArray);
error_reporting(0);
$countDots = 0;
foreach($folds as $key => $value) {
    $foldActionParam = explode("=",$value);

    $foldAction = $foldActionParam[0];
    $foldAmount = $foldActionParam[1];


    if($foldAction[0]=='y') {

    } else {

    }
    // Update the values
    for ($x = 0; $x <= $gridWidth; $x++) {
        for ($y = 0; $y <= $gridLength; $y++) {
            if($y < $foldAmount && $foldAction == 'x'){
                $newY = ($y + (($foldAmount-$y)*2));
                $getValue = $gridArray[$x][$newY];
                //echo "fold $y at $foldAmount - $newY - $x,$y<br>";
                if($getValue == '#' || $gridArray[$x][$y] == '#') {
                    $gridArray[$x][$y] = '#';
                }

            } elseif ($x < $foldAmount && $foldAction == 'y'){
                $newX = ($x + (($foldAmount-$x)*2));
                $getValue = $gridArray[$newX][$y];
                if($getValue == '#' || $gridArray[$x][$y] == '#') {
                    $gridArray[$x][$y] = '#';
                }
            }
        }
    }

    // Cleanup the array
    for ($x = 0; $x <= $gridWidth; $x++) {
        for ($y = 0; $y <= $gridLength; $y++) {
            if($y >= $foldAmount && $foldAction == 'x'){
                unset($gridArray[$x][$y]);
            } elseif ($x >= $foldAmount && $foldAction == 'y'){
                unset($gridArray[$x][$y]);
            }
        }
        if(empty($gridArray[$x])) {
            unset($gridArray[$x]);
        }
    }

    //break;
    if($key==0) {
        for ($x = 0; $x <= $gridWidth; $x++) {
            for ($y = 0; $y <= $gridLength; $y++) {
                if(isset($gridArray[$x][$y]) && $gridArray[$x][$y] =='#') {
                    $countDots++;
                }
            }
        }
    }

    //printGrid($gridArray);
    $time_post = microtime(true);
    $exec_time = $time_post - $time_pre;
    echo "Completed fold # $key in $exec_time seconds<br>";
    ob_flush();
    flush();

}

// Cleanup the array
for ($x = 0; $x <= $gridWidth; $x++) {
    for ($y = 0; $y <= $gridLength; $y++) {
        if(isset($gridArray[$x][$y]) && $gridArray[$x][$y] =='.') {
            $gridArray[$x][$y] = '&nbsp;';
        }
    }
}

echo "<br>Day 13 Part A: Total dots after 1 fold is ".$countDots."<br><br>";
echo "Day 13 Part B: Solution code is:<br><br>";
printGrid($gridArray);

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "<br>Spent $exec_time seconds so far<br>";