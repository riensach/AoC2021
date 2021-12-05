<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-4);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "0,9 -> 5,9
//8,0 -> 0,8
//9,4 -> 3,4
//2,2 -> 2,1
//7,0 -> 7,4
//6,4 -> 2,0
//0,9 -> 2,9
//3,4 -> 1,4
//0,0 -> 8,8
//5,5 -> 8,2";

$inputArray = explode("\n",$puzzleInput);

$gridArray = array();
$gridSize = 1000;

for ($x = 0; $x < $gridSize; $x++) {
    for ($y = 0; $y < $gridSize; $y++) {
        $gridArray[$x][$y] = '.';
    }
}


foreach($inputArray as $key => $value) {
    $points = explode(" -> ",$value);
    $lineStart = explode(",",$points[0]);
    $lineEnd = explode(",",$points[1]);

    // Check if I need to flip the points.
    if($lineStart[0] > $lineEnd[0]) {
        $tempStart = $lineStart[0];
        $lineStart[0] = $lineEnd[0];
        $lineEnd[0] = $tempStart;
    }
    // Check if I need to flip the points.
    if($lineStart[1] > $lineEnd[1]) {
        $tempStart = $lineStart[1];
        $lineStart[1] = $lineEnd[1];
        $lineEnd[1] = $tempStart;
    }

    if($lineStart[0] <> $lineEnd[0] && $lineStart[1] <> $lineEnd[1]) {
        // Only consider vertical lines currently
        continue;
    }

    $lineStartColumnIterator = $lineStart[0];
    $lineStartRowIterator = $lineStart[1];

   // echo "Running from $lineStartColumnIterator,$lineStartRowIterator to ".$lineEnd[0].",".$lineEnd[1]."<br>";

    while($lineStartColumnIterator <= $lineEnd[0]) {
        while($lineStartRowIterator <= $lineEnd[1]) {
            $currentGridArrayValue = $gridArray[$lineStartRowIterator][$lineStartColumnIterator];
           // echo "&nbsp;&nbsp;&nbsp;&nbsp;Placing line at $lineStartColumnIterator,$lineStartRowIterator<br>";
            if($currentGridArrayValue=='.') {
                $gridArray[$lineStartRowIterator][$lineStartColumnIterator] = 1;
            } else {
                $gridArray[$lineStartRowIterator][$lineStartColumnIterator] = $gridArray[$lineStartRowIterator][$lineStartColumnIterator] + 1;
            }
            $lineStartRowIterator++;
        }
        $lineStartColumnIterator++;
        $lineStartRowIterator = $lineStart[1];
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


$totalPoints = 0;
foreach($gridArray as $key => $value) {
    foreach($value as $key2 => $value2) {
        if($gridArray[$key][$key2] > 1){
            $totalPoints++;
        }
    }
}











echo "Day 4 Part A: ".$totalPoints."<br>";
echo "Day 4 Part B: ".$lifeSupportRating."<br>";



$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";
