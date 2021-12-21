<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-6);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "Player 1 starting position: 4
//Player 2 starting position: 8";

$inputArray = explode("\n",$puzzleInput);

$playerAStartingPosition = str_replace("Player 1 starting position: ", "", $inputArray[0]);
$playerBStartingPosition = str_replace("Player 2 starting position: ", "", $inputArray[1]);

$diceFace = 0;
$diceRolls = 0;

$playerAScore = 0;
$playerBScore = 0;


$playerAPosition = $playerAStartingPosition;
$playerBPosition = $playerBStartingPosition;

$diceArrayOptions = array();
for($x = 1; $x < 4; $x++) {
    for($y = 1; $y < 4; $y++) {
        for($z = 1; $z < 4; $z++) {
            $diceArrayOptions[] = $x+$y+$z;
        }
    }
}

sort($diceArrayOptions);
var_dump($diceArrayOptions);
$diceArrayOptionsDeDupe = array();
foreach($diceArrayOptions as $key => $value) {
    if(!isset($diceArrayOptionsDeDupe[$value])) {
        $diceArrayOptionsDeDupe[$value] = 1;
    } else {
        $diceArrayOptionsDeDupe[$value] = $diceArrayOptionsDeDupe[$value] + 1;
    }
}

var_dump($diceArrayOptionsDeDupe);



function diceGame($playerAScore, $playerBScore, &$playerAWins, &$playerBWins, $move, $playerAPosition, $playerBPosition, &$diceArrayOptionsDeDupe, $duplicateScenariosHere) {

    if($playerAScore > 20) {
        $playerAWins = $playerAWins + $duplicateScenariosHere;
        return;
    } elseif($playerBScore > 20) {
        $playerBWins = $playerBWins + $duplicateScenariosHere;
        return;
    }

    if(($playerAWins % 10000000) == 1) {
        echo "Player A wins is $playerAWins<br>\n";
        echo "Player B wins is $playerBWins<br>\n";
    }

    if($move == 1) {
        // Player A moves
        foreach($diceArrayOptionsDeDupe as $key => $value) {
            $tempAPosition = $playerAPosition;
            $tempAScore = $playerAScore;
            $tempAPosition = ($tempAPosition + $key) % 10;
            if($tempAPosition == 0) {
                $tempAPosition = 10;
            }
            $tempAScore += $tempAPosition;
            $tempDupScenarios = $duplicateScenariosHere * $value;
            //echo "Move: $move ; PlayerAScore: $tempAScore ; PlayerBScore: $playerBScore - PlayerAPosition: $tempAPosition ; PlayerBPosition: $playerBPosition ; Dup scenarios: $tempDupScenarios<br>";
            diceGame($tempAScore, $playerBScore, $playerAWins, $playerBWins, 4, $tempAPosition, $playerBPosition,$diceArrayOptionsDeDupe, $tempDupScenarios);
        }
    } else {
        // Player B moves
        foreach($diceArrayOptionsDeDupe as $key => $value) {
            $tempBPosition = $playerBPosition;
            $tempBScore = $playerBScore;
            $tempBPosition = ($tempBPosition + $key) % 10;
            if($tempBPosition == 0) {
                $tempBPosition = 10;
            }
            $tempBScore += $tempBPosition;
            $tempDupScenarios = $duplicateScenariosHere * $value;
            //echo "Move: $move ; PlayerAScore: $playerAScore ; PlayerBScore: $tempBScore - PlayerAPosition: $playerAPosition ; PlayerBPosition: $tempBPosition ; Dup scenarios: $tempDupScenarios<br>";
            diceGame($playerAScore, $tempBScore, $playerAWins, $playerBWins, 1, $playerAPosition, $tempBPosition,$diceArrayOptionsDeDupe, $tempDupScenarios);
        }
    }
    //echo "Diceface: $diceFace ; Move: $move ; PlayerAScore: $playerAScore ; PlayerBScore: $playerBScore - PlayerAPosition: $playerAPosition ; PlayerBPosition: $playerBPosition<br>";





    // 444356092776315
    // 341960390180808
    // 1130000001
    //
    // 140000001 (9:42)



}

$playerAWins = 0;
$playerBWins = 0;

diceGame(0, 0, $playerAWins, $playerBWins, 1, $playerAPosition, $playerBPosition,$diceArrayOptionsDeDupe, 1);



if($playerAWins > $playerBWins) {
    $winningPlayer = "A";
    $totalWins = $playerAWins;
} else {
    $winningPlayer = "B";
    $totalWins = $playerBWins;
}





echo "Day 21 Part B: Most wins by player ".$winningPlayer." with ".$totalWins." wins<br><br>\n";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";