<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "target area: x=20..30, y=-10..-5";

//Input processing
$string = explode(',',$puzzleInput);
$xString = str_replace('target area: x=','', $string[0]);
$yString = str_replace(' y=','', $string[1]);
$xStringCoords = explode('..',$xString);
$yStringCoords = explode('..',$yString);
$TargetXFrom = $xStringCoords[0];
$TargetXTo = $xStringCoords[1];
$TargetYFrom = $yStringCoords[0];
$TargetYTo = $yStringCoords[1];

$probeX = 0;
$probeY = 0;
$highestY = 0;

function calculatePath($forwardVelocity,$upwardVelocity,$TargetXFrom,$TargetXTo,$TargetYFrom,$TargetYTo,&$highestY,&$options) {
    $probeX = 0;
    $probeY = 0;
    $steps = 0;
    $highestCurrentProbeY = 0;
    $startingForwardVelocity = $forwardVelocity;
    $startingUpwardsVelocity = $upwardVelocity;
    $probeHitTarget = 0;
    while($steps < 10000) {
        $probeX = $probeX + $forwardVelocity;
        $probeY = $probeY + $upwardVelocity;
        if($probeY > $highestCurrentProbeY) {
            $highestCurrentProbeY = $probeY;
        }
        if($forwardVelocity==0) {
            // Do nothing
        } elseif($forwardVelocity > 0) {
            $forwardVelocity--;
        } elseif($forwardVelocity < 0) {
            $forwardVelocity++;
        }
        $upwardVelocity--;
        if($probeX >= $TargetXFrom && $probeX <= $TargetXTo && $probeY >= $TargetYFrom && $probeY <= $TargetYTo) {
            // In range!
            $probeHitTarget = 1;
        }
        if($probeX > $TargetXTo || ($probeY < $TargetYTo && $forwardVelocity < 1)) {
            break;
        }
        $steps++;
    }

    if($probeHitTarget == 1 && $highestCurrentProbeY > $highestY) {
        $highestY = $highestCurrentProbeY;
    }
    if($probeHitTarget == 1) {
        $options[] = array('x' => $startingForwardVelocity, 'y' => $startingUpwardsVelocity);
    }

}

$startingX = -100;
$startingY = -100;

$maximumX = 300;
$maximumY = 300;
$options = array();

for($x = $startingX; $x < $maximumX; $x++) {
    for($y = $startingY; $y < $maximumY; $y++) {
        calculatePath($x,$y,$TargetXFrom,$TargetXTo,$TargetYFrom,$TargetYTo,$highestY,$options);
    }
}

$countOptions = count($options);

echo "Day 17 Part A: Highest Y position reached ".$highestY."<br><br>\n";
echo "Day 17 Part B: Distinct options ".$countOptions."<br><br>\n";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";