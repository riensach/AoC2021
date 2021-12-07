<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "3,4,3,1,2";
$totalDays = 256;
$lanternFish = explode(",",$puzzleInput);
$baseFish = count($lanternFish);
$totalNewFish = 0;

$totalFish = array();
for ($x = 0; $x < 9; $x++) {
    $totalFish[$x] = 0;
}
foreach($lanternFish as $key => $daysUntilNew) {
    $totalFish[$daysUntilNew] = $totalFish[$daysUntilNew] + 1;
}

var_dump($totalFish);

for ($x = 0; $x < $totalDays; $x++) {
    $tempTotalFish = $totalFish;
    foreach($totalFish as $key => $fishPerDay) {

        if($key==0) {
            $tempTotalFish[6] = $fishPerDay;
            $tempTotalFish[8] = $fishPerDay;
            $tempTotalFish[0] = $totalFish[1];
        } elseif($key==8) {
            //$tempTotalFish[$key] += $totalFish[$key+1];
        } elseif($key==6) {
            $tempTotalFish[$key] += $totalFish[$key+1];
        } else {
            $tempTotalFish[$key] = $totalFish[$key+1];
        }

    }
    $totalFish = $tempTotalFish;
}
var_dump($totalFish);
$totalFish = array_sum($totalFish);


echo "Day 6 Part A: ".$totalFish."<br>";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";
