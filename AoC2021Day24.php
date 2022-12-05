<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';


//$puzzleInput = "inp w
//add z w
//mod z 2
//div w 2
//add y w
//mod y 2
//div w 2
//add x w
//mod x 2
//div w 2
//mod w 2";

$inputArray = explode("\n",$puzzleInput);



$commands = array();



foreach($inputArray as $key => $value) {

    $values = explode(" ",$value);
    if($values[0] == 'inp') {
        $commands[] = array('command' => $values[0], 'firstValue' => $values[1]);
    } else {
        $commands[] = array('command' => $values[0], 'firstValue' => $values[1], 'secondValue' => $values[2]);
    }

}
$validNumber = 0;
$maximumNumber = 71899999999999;
$minimumNumber = 11111111111111;
$iteration = 1;
for($numberVariable = $maximumNumber; $numberVariable >= $minimumNumber; $numberVariable--) {
    $numberFound0 = strpos($numberVariable, '0');
    if($numberFound0 !== false) {
        // There is a zero in this number, continue to try the next number
        continue;
    }

    $modelNumber = str_split($numberVariable,1);
    $variables = array('w' => 0, 'x' => 0, 'y' => 0, 'z' => 0);

    echo "Running with input $numberVariable<br>";
    $inputIterator = 0;
    foreach($commands as $key => $value) {
        if($value['command'] == 'inp') {
            $variables[$value['firstValue']] = (int) $modelNumber[$inputIterator];
            echo "Using input ".$modelNumber[$inputIterator]." at position $inputIterator<br>";
            $inputIterator++;
        } elseif($value['command'] == 'add') {
            if(is_numeric($value['secondValue'])) {
                $variables[$value['firstValue']] = (int) ($variables[$value['firstValue']] + $value['secondValue']);
            } else {
                $variables[$value['firstValue']] = (int) ($variables[$value['firstValue']] + $variables[$value['secondValue']]);
            }
        } elseif($value['command'] == 'mul') {
            if(is_numeric($value['secondValue'])) {
                $variables[$value['firstValue']] = (int) ($variables[$value['firstValue']] * $value['secondValue']);
            } else {
                $variables[$value['firstValue']] = (int) ($variables[$value['firstValue']] * $variables[$value['secondValue']]);
            }
        } elseif($value['command'] == 'div') {
            if(is_numeric($value['secondValue'])) {
                $variables[$value['firstValue']] = (int) ($variables[$value['firstValue']] / $value['secondValue']);
            } else {
                $variables[$value['firstValue']] = (int) floor($variables[$value['firstValue']] / $variables[$value['secondValue']]);
            }
        } elseif($value['command'] == 'mod') {
            if(is_numeric($value['secondValue'])) {
                $variables[$value['firstValue']] = (int) ($variables[$value['firstValue']] % $value['secondValue']);
            } else {
                $variables[$value['firstValue']] = (int) ($variables[$value['firstValue']] % $variables[$value['secondValue']]);
            }
        } elseif($value['command'] == 'eql') {
            if(is_numeric($value['secondValue']) && $variables[$value['firstValue']] == $value['secondValue']) {
                $variables[$value['firstValue']] = 1;
            } elseif(!is_numeric($value['secondValue']) && $variables[$value['firstValue']] == $variables[$value['secondValue']]) {
                $variables[$value['firstValue']] = 1;
            } else {
                $variables[$value['firstValue']] = 0;
            }
        } else {
            echo "how did we get here";
        }
        var_dump($variables);
    }

    $finalValue = $variables['z'];

    $iteration++;
    echo "Final value for model number $numberVariable is $finalValue<br>";
    if($iteration > 10) {
        break;
    }

    if($finalValue == 0) {
        //valid!
        $validNumber = $numberVariable;
        break;
    }

    $time_post = microtime(true);
    $exec_time = $time_post - $time_pre;
    if(floor($exec_time) % 10 == 0) {
        //echo "Spent $exec_time seconds so far - currently on number $numberVariable<br>\n";
    }

}







echo "Day 24 Part A: Maximum accepted number is ".$validNumber."<br><br>\n";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";