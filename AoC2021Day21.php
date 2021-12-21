<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';

$puzzleInput = "Player 1 starting position: 4
Player 2 starting position: 8";

$inputArray = explode("\n",$puzzleInput);

$playerAStartingPosition = str_replace("Player 1 starting position: ", "", $inputArray[0]);
$playerBStartingPosition = str_replace("Player 2 starting position: ", "", $inputArray[1]);

$diceFace = 0;
$diceRolls = 0;

$playerAScore = 0;
$playerBScore = 0;

echo "$playerAStartingPosition - $playerBStartingPosition<br>";

$playerAPosition = $playerAStartingPosition;
$playerBPosition = $playerBStartingPosition;
while($playerAScore < 1000 && $playerBScore < 1000) {
    $diceFace++;
    $diceFace1 = $diceFace % 100;
    $diceFace2 = ($diceFace + 1) % 100;
    $diceFace3 = ($diceFace + 2) % 100;
    $diceFace = $diceFace + 2;
    if($diceFace > 100) {
        $diceFace = $diceFace % 100;
    }
    $diceRolls += 3;
    $playerAPosition = ($playerAPosition + $diceFace1 + $diceFace2 + $diceFace3) % 10;
    if($playerAPosition ==0) {
        $playerAPosition = 10;
    }
    $playerAScore += $playerAPosition;
    //echo "Player A position: $playerAPosition ($diceFace1 - $diceFace2 - $diceFace3) - Player A Score: $playerAScore<br>";

    if($playerAScore >= 1000) {
        break;
    }


    $diceFace++;
    $diceFace1 = $diceFace % 100;
    $diceFace2 = ($diceFace + 1) % 100;
    $diceFace3 = ($diceFace + 2) % 100;
    $diceFace = $diceFace + 2;
    if($diceFace > 100) {
        $diceFace = $diceFace % 100;
    }
    $diceRolls += 3;
    $playerBPosition = ($playerBPosition + $diceFace1 + $diceFace2 + $diceFace3) % 10;
    if($playerBPosition ==0) {
        $playerBPosition = 10;
    }
    $playerBScore += $playerBPosition;
    //echo "Player B position: $playerBPosition ($diceFace1 - $diceFace2 - $diceFace3) - Player A Score: $playerBScore<br>";



    if($playerBScore >= 1000) {
        break;
    }
}

if($playerAScore < $playerBScore) {
    $finalDiceCalc = $playerAScore * $diceRolls;
    echo "Player B wins - $playerAScore :: $diceRolls :: $finalDiceCalc<br>";
} else {
    $finalDiceCalc = $playerBScore * $diceRolls;
    echo "Player A wins - $playerBScore :: $diceRolls :: $finalDiceCalc<br>";
}





echo "Day 21 Part A: Total lit pixels ".$finalDiceCalc."<br><br>\n";
echo "Day 21 Part B: Total lit pixels ".$lightPixelsPartB."<br><br>\n";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";