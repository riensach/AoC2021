<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "[({(<(())[]>[[{[]{<()<>>
//[(()[<>])]({[<{<<[]>>(
//{([(<{}[<>[]}>{[]{[(<()>
//(((({<>}<{<{<>}{[]{[]{}
//[[<[([]))<([[{}[[()]]]
//[{[{({}]{}}([{[{{{}}([]
//{<[[]]>}<{[{[{[]{()[[[]
//[<(<(<(<{}))><([]([]()
//<{([([[(<>()){}]>(<<{{
//<{([{{}}[<[[[<>{}]]]>[]]";

$inputArray = explode("\n",$puzzleInput);

$pointsTotal = 0;
$pairs = array('{' => '}', '[' => ']', '(' => ')', '<' => '>');
$points = array(')' => 3, ']' => 57, '}' => 1197, '>' => 25137);
$pointsB = array(')' => 1, ']' => 2, '}' => 3,  '>' => 4);

$partBScores = array();
foreach($inputArray as $key => $value) {
    $values = str_split($value,1);
    $order = array();
    $corrupted = 0;
    foreach($values as $key2 => $nextValue) {
        if(isset($pairs[$nextValue])) {
            // It's another opening
            $order[] = $nextValue;
        } else {
            $lastKey = array_key_last($order);
            $lastValue = $order[$lastKey];
            $lastValue = $pairs[$lastValue];

            if($lastValue==$nextValue) {
                // This is the expected value
                array_pop($order);
            } else {
                //UNEXPECTED!!!
                $pointsToAdd = $points[$nextValue];
                $pointsTotal += $pointsToAdd;

                //echo "Found an unexpected $nextValue (expected $lastValue ), adding $pointsToAdd to $pointsTotal<br>";
                // This is a corrupted line
                $corrupted = 1;
                break;
            }
        }
    }
    if($corrupted <> 1) {
        //Incomplete lines!

        $incompleteLines[] = $values;
        $order = array_reverse($order);
        $pointsSecond = 0;

        foreach($order as $key2 => $nextValue) {
            $nextValue = $pairs[$nextValue];
            $pointsToAdd = $pointsB[$nextValue];
            $pointsSecond = $pointsSecond * 5;
            $pointsSecond += $pointsToAdd;
        }
        $partBScores[] = $pointsSecond;

    }
}

sort($partBScores);
$numberOfScores = count($partBScores);
$scoreToFind = floor($numberOfScores / 2);

$middleScore = $partBScores[$scoreToFind];

echo "Day 10 Part A: Total points are ".$pointsTotal."<br>";
echo "Day 10 Part B: Middle score is ".$middleScore."<br>";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";