<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "7,4,9,5,11,17,23,2,0,14,21,24,10,16,13,6,15,25,12,22,18,20,8,19,3,26,1
//
//22 13 17 11  0
// 8  2 23  4 24
//21  9 14 16  7
// 6 10  3 18  5
// 1 12 20 15 19
//
// 3 15  0  2 22
// 9 18 13 17  5
//19  8  7 25 23
//20 11 10 24  4
//14 21 16 12  6
//
//14 21 17 24  4
//10 16 15  9 19
//18  8 23 26 20
//22 11 13  6  5
// 2  0 12  3  7";

$inputArray = explode("\n",$puzzleInput);

$winningNumbers = $inputArray[0];
$winningNumbers = explode(",",$winningNumbers);
unset($inputArray[0]);
$inputArray = array_filter($inputArray);
$inputArray = array_values($inputArray);
$totalBoards = count($inputArray) / 5;
$arrayPosition = 0;
$boards = array();

function specialArrayFilter($var){
    return ($var !== NULL && $var !== FALSE && $var !== '');
}

for ($boardIterator = 1; $boardIterator <= $totalBoards; $boardIterator++) {
    $boardRow1 = explode(" ",$inputArray[$arrayPosition]);
    $boardRow1 = array_filter($boardRow1, 'specialArrayFilter');
    $boardRow1 = array_values($boardRow1);
    $boardRow2 = explode(" ",$inputArray[$arrayPosition+1]);
    $boardRow2 = array_filter($boardRow2, 'specialArrayFilter');
    $boardRow2 = array_values($boardRow2);
    $boardRow3 = explode(" ",$inputArray[$arrayPosition+2]);
    $boardRow3 = array_filter($boardRow3, 'specialArrayFilter');
    $boardRow3 = array_values($boardRow3);
    $boardRow4 = explode(" ",$inputArray[$arrayPosition+3]);
    $boardRow4 = array_filter($boardRow4, 'specialArrayFilter');
    $boardRow4 = array_values($boardRow4);
    $boardRow5 = explode(" ",$inputArray[$arrayPosition+4]);
    $boardRow5 = array_filter($boardRow5, 'specialArrayFilter');
    $boardRow5 = array_values($boardRow5);
    $boards[$boardIterator] = array($boardRow1,$boardRow2,$boardRow3,$boardRow4,$boardRow5);
    $arrayPosition = $arrayPosition + 5;
}


//var_dump($boards);

function markNumbers($numberToMark, $boards) {
    foreach($boards as $key => $line) {
        foreach($line as $key2 => $column) {
            foreach($column as $key3 => $value) {
                if($value == $numberToMark) {
                    $boards[$key][$key2][$key3] = "X";

                }
            }

        }
    }
    return $boards;
}

function checkBoards($boards) {
    $keys = array();
    foreach($boards as $key => $line) {
        $columnCount[0] = 0;
        $columnCount[1] = 0;
        $columnCount[2] = 0;
        $columnCount[3] = 0;
        $columnCount[4] = 0;
        foreach($line as $key2 => $column) {
            $rowCount = 0;
            foreach($column as $key3 => $value) {
                if($value == "X") {
                    $columnCount[$key3]++;
                    $rowCount++;
                }
            }
            if($rowCount > 4) {
                // Found a winning row
                $keys[] = $key;
            }

        }
        if($columnCount[0] > 4 || $columnCount[1] > 4 || $columnCount[2] > 4 || $columnCount[3] > 4 || $columnCount[4] > 4) {
            // Found a winning column
            $keys[] = $key;
        }
    }
    return $keys;
}


function winningBoardUnmarkedSum($winnerBoardID, $boards) {

    $unmarkedSum = 0;
    foreach($boards[$winnerBoardID] as $key2 => $column) {
        foreach($column as $key3 => $value) {
            if($value <> "X") {
                $unmarkedSum = $unmarkedSum + $value;
            }
        }
    }

    return $unmarkedSum;

}




$winnerFound = 0;
$lastNumber = 0;
$winnerBoardID = array();

foreach($winningNumbers as $key => $winningNumber) {

    $lastNumber = $winningNumber;
    $boards = markNumbers($winningNumber, $boards);
    $winnerBoardID = checkBoards($boards);
    $boardCount = count($boards);
    $winnerBoardCount = count($winnerBoardID);
    echo "Checking number $winningNumber - found winner? $winnerBoardCount - $boardCount<br>";
    if(count($winnerBoardID) > 0) {
        if(count($boards)>1) {
            foreach($winnerBoardID as $key => $value) {
                unset($boards[$value]);
            }
        } else {
            $winnerBoardID = array_key_first($boards);
            echo $winnerBoardID;
            break;
        }
      //  break;
    }


}

//var_dump($boards);
$calculateSolution = winningBoardUnmarkedSum($winnerBoardID, $boards) * $lastNumber;


echo "Day 4 Part A: ".$calculateSolution."<br>";
//echo "Day 4 Part B: ".$lifeSupportRating."<br>";



$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";
