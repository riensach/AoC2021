<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-6);
$puzzleInput = require 'input/'.$fileName.'.php';
//
//$puzzleInput = "1163751742
//1381373672
//2136511328
//3694931569
//7463417111
//1319128137
//1359912421
//3125421639
//1293138521
//2311944581";

$inputArray = explode("\n",$puzzleInput);

$gridArray = array();
$height = 0;
$width = 0;

foreach($inputArray as $key => $value) {

    $strSplit = str_split($value,1);
    foreach($strSplit as $key2 => $value2) {
        $gridArray[$key][$key2] = $value2;
    }
}

$height = array_key_last($gridArray);
$width = array_key_last($gridArray[1]);

foreach($gridArray as $key => $value) {
    for($x = 1; $x < 5; $x++) {
        foreach($value as $key2 => $value2) {
            $gridArray[$key][$key2+(($width+1)*$x)] = $value2+$x > 9 ? $value2+$x-9:$value2+$x;
        }
    }
}

foreach($gridArray as $key => $value) {
    for($x = 1; $x < 5; $x++) {
        foreach($value as $key2 => $value2) {
        $gridArray[$key+(($height+1)*$x)][$key2] = $value2+$x > 9 ? $value2+$x-9:$value2+$x;
        }
    }
}

$height = array_key_last($gridArray);
$width = array_key_last($gridArray[1]);

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

//echo "$height - $width<br>";

$records = array();

function attemptPath($currentPosition, $finalDestination, $previousPosition, &$gridArray, $moves, $risk, &$records, &$previousCoordsArray) {
    if(isset($previousCoordsArray[$currentPosition[0].",".$currentPosition[1]]) && $previousCoordsArray[$currentPosition[0].",".$currentPosition[1]] <= $risk) {
        // I've been here before, and for cheaper!
        return;
    }
//    if(count($records) > 2000) {
//        // Lets stop for now!
//        return;
//    }
//    if($moves > 450) {
//        // This path won't work for us, end it
//        return;
//    }
    if((isset($records[0]['totalRisk']) && $risk > $records[0]['totalRisk']) || $risk > 2914 || $moves > 1010) {
        // Risk is already too high, leave it
        return;
    }
    //$currentPositionCoord = explode(",", $currentPosition);

    //$finalDestintionCoord = explode(",", $finalDestination);
    $previousPositionCoord = $previousPosition[0].",".$previousPosition[1];
    $positionAbove = $gridArray[$currentPosition[0]-1][$currentPosition[1]] ?? null;
    $positionAboveCoord = array(0=>($currentPosition[0]-1),1=>$currentPosition[1]);
    $positionBelow = $gridArray[$currentPosition[0]+1][$currentPosition[1]] ?? null;
    $positionBelowCoord = array(0=>($currentPosition[0]+1),1=>$currentPosition[1]);
    $positionLeft = $gridArray[$currentPosition[0]][$currentPosition[1]-1] ?? 0;
    $positionLeftCoord = array(0=>$currentPosition[0],1=>($currentPosition[1]-1));
    $positionRight = $gridArray[$currentPosition[0]][$currentPosition[1]+1] ?? null;
    $positionRightCoord = array(0=>$currentPosition[0],1=>($currentPosition[1]+1));

    if($currentPosition[0] == $finalDestination[0] && $currentPosition[1] == $finalDestination[1] ) {
        // Record this, end this path
        $records[0] = array('totalRisk' => $risk, 'totalMoves' => $moves);
        //$columns = array_column($records, 'totalRisk');
        //array_multisort($columns, SORT_ASC, $records);
        $lowestRisk = $records[0]['totalRisk'];
        $numberOfMoves = $records[0]['totalMoves'];
        echo "Lowest risk found so far $lowestRisk in $numberOfMoves moves.\n<br>";
        //ob_flush();
        flush();
        return;
    }

    $previousCoordsArray[$currentPosition[0].",".$currentPosition[1]] = $risk;

    if(!is_null($positionBelow) && $positionBelowCoord[0] <> $previousPositionCoord[0] && $positionBelowCoord[1] <> $previousPositionCoord[1] && $positionBelow > 0) {
        // Continue with this path!
        //echo "Pathing option below from $previousPosition to $positionBelowCoord, attempting to move there.<br>";
        $newRisk = $risk + $positionBelow;
        //$gridArray[$currentPositionCoord[0]+1][$currentPositionCoord[1]] = -1;

        attemptPath($positionBelowCoord,$finalDestination,$currentPosition,$gridArray,$moves+1,$newRisk,$records, $previousCoordsArray);
    }

    if(!is_null($positionLeft) && $positionLeftCoord[0] <> $previousPositionCoord[0] && $positionLeftCoord[1] <> $previousPositionCoord[1] && $positionLeft > 0) {
        // Continue with this path!
        //echo "Pathing option left from $previousPosition to $positionLeftCoord, attempting to move there.<br>";
        $newRisk = $risk + $positionLeft;
        //$gridArray[$currentPositionCoord[0]][$currentPositionCoord[1]-1] = -1;
        attemptPath($positionLeftCoord,$finalDestination,$currentPosition,$gridArray,$moves+1,$newRisk,$records, $previousCoordsArray);
    }



    if(!is_null($positionRight) && $positionRightCoord[0] <> $previousPositionCoord[0] && $positionRightCoord[1] <> $previousPositionCoord[1] && $positionRight > 0) {
        // Continue with this path!
        //echo "Pathing option right from $previousPosition to $positionRightCoord, attempting to move there.<br>";
        $newRisk = $risk + $positionRight;
        //$gridArray[$currentPositionCoord[0]][$currentPositionCoord[1]+1] = -1;
        attemptPath($positionRightCoord,$finalDestination,$currentPosition,$gridArray,$moves+1,$newRisk,$records, $previousCoordsArray);
    }

    if(!is_null($positionAbove) && $positionAboveCoord[0] <> $previousPositionCoord[0] && $positionAboveCoord[1] <> $previousPositionCoord[1] && $positionAbove > 0) {
        // Continue with this path!
        //echo "Pathing option above from $previousPosition to $positionAboveCoord, attempting to move there.<br>";
        $newRisk = $risk + $positionAbove;
        //$gridArray[$currentPositionCoord[0]-1][$currentPositionCoord[1]] = -1;
        attemptPath($positionAboveCoord,$finalDestination,$currentPosition,$gridArray,$moves+1,$newRisk,$records, $previousCoordsArray);
    }







    return;

}
$previousCoordsArray = array();

attemptPath(array(0=>0,1=>0),array(0=>$height,1=>$width),array(0=>-1,1=>-1),$gridArray,0,0,$records, $previousCoordsArray);

//var_dump($records);

$lowestRisk = $records[0]['totalRisk'];
$numberOfMoves = $records[0]['totalMoves'];

$columns = array_column($records, 'totalMoves');
array_multisort($columns, SORT_ASC, $records);

$lowestNumberOfMoves = $records[0]['totalMoves'];

echo "Day 15 Part A: Lowest total risk ".$lowestRisk." in ".$numberOfMoves." moves<br>";
echo "Day 15 Part B: Lowest total moves? ".$lowestNumberOfMoves."<br>";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";