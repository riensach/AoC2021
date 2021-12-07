<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-4);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "3,4,3,1,2";

$lanternFish = explode(",",$puzzleInput);

// New every 7 days

$totalDays = 80;
$patterns = array();
$prevPool = count($lanternFish);
for ($x = 0; $x < $totalDays; $x++) {
    foreach($lanternFish as $key => $daysUntilNew) {
        if($daysUntilNew==0) {
            $lanternFish[] = 8;
            $lanternFish[$key] = 6;
        } else {
            (int)$lanternFish[$key] = (int)$lanternFish[$key] - 1;
        }
        //echo $lanternFish[$key]."<br>";
    }
//    $stringConv = implode(',',$lanternFish);
//    $poolSize = count($lanternFish);
//    if(isset($patterns[$stringConv])) {
//        $prevLoop = $patterns[$stringConv];
//        echo "Found this pattern before at loop $prevLoop, now at look $x<br>";
//    } else {
//        $diff = $poolSize - $prevPool;
//        $prevPool = $poolSize;
//        echo "Pool size: $poolSize (+$diff)<br>";
//        $patterns[$stringConv] = $x;
//    }
    //var_dump($patterns);
}

$totalFish = count($lanternFish);
echo "Day 6 Part A: ".$totalFish."<br>";

$totalDays = 80;
$lanternFish = explode(",",$puzzleInput);
$lanternFishD = new \Ds\Deque();
foreach($lanternFish as $key => $daysUntilNew) {
    $lanternFishD->push((int)$daysUntilNew);
}

//var_dump($lanternFishD->toArray());

$totalRotations = $lanternFishD->count();
$totalAdditions = 0;
for ($x = 0; $x < $totalDays; $x++) {
    $totalRotations = $totalRotations + $totalAdditions;
    $totalAdditions = 0;
    for ($y = 0; $y < $totalRotations; $y++) {
        $daysUntilNew = $lanternFishD->get(0);
        if($daysUntilNew==0) {
            $lanternFishD->set(0,6);
            $lanternFishD->push(8);
            $totalAdditions++;
        } else {
            $newValue = $daysUntilNew - 1;
            $lanternFishD->set(0,$newValue);
        }
        $lanternFishD->rotate(1);
    }

    $lanternFishD->rotate(-$totalRotations);
    //var_dump($lanternFishDTemp->toArray());

    $time_post = microtime(true);
    $exec_time = $time_post - $time_pre;
    echo "Rotation $x done in $exec_time seconds<br>";
    flush();
    ob_flush();
}







$totalFish = $lanternFishD->count();




echo "Day 6 Part A: ".$totalFish."<br>";



$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";
