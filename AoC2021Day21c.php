<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-6);
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


$playerAPosition = $playerAStartingPosition;
$playerBPosition = $playerBStartingPosition;


$totalGames = 341960390180808 + 444356092776315;

echo "$totalGames";



$playerAWins = 0;
$PlayerBWins = 0;







echo "Day 21 Part B: Most wins by player ".$winningPlayer." with ".$totalWins." wins<br><br>\n";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";