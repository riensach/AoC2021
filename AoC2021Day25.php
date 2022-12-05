<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';


//$puzzleInput = "v...>>.vv>
//.vv>>.vv..
//>>.>v>...v
//>>v>>.>.v.
//v>v.vv.v..
//>.>>..v...
//.vv..>.>v.
//v.v..>>v.v
//....v..v.>";

//$puzzleInput = "..........
//.>v....v..
//.......>..
//..........";

$inputArray = explode("\n",$puzzleInput);



$gridArray = array();



foreach($inputArray as $key => $value) {
    $values = str_split($value,1);
    foreach($values as $key2 => $value2) {
        $gridArray[$key][$key2] = $value2;

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

$forceEndSteps = 1000;

printGrid($gridArray);
for($steps = 0; $steps < $forceEndSteps; $steps++) {
    $tempArray = $gridArray;
    $moved = 0;
    foreach($gridArray as $key => $value) {
        foreach($value as $key2 => $value2) {
            if($value2 == '>') {
                if(isset($gridArray[$key][$key2+1]) && $gridArray[$key][$key2+1] == '.') {
                    $tempArray[$key][$key2+1] = '>';
                    $tempArray[$key][$key2] = '.';
                    $moved = 1;
                } elseif(!isset($gridArray[$key][$key2+1]) && $gridArray[$key][0] == '.') {
                    $tempArray[$key][0] = '>';
                    $tempArray[$key][$key2] = '.';
                    $moved = 1;
                }
            }
        }
    }
    $gridArray = $tempArray;
    foreach($gridArray as $key => $value) {
        foreach($value as $key2 => $value2) {
            if($value2 == 'v') {
                if(isset($gridArray[$key+1][$key2]) && $gridArray[$key+1][$key2] == '.') {
                    $tempArray[$key+1][$key2] = 'v';
                    $tempArray[$key][$key2] = '.';
                    $moved = 1;
                } elseif(!isset($gridArray[$key+1][$key2]) && $gridArray[0][$key2] == '.') {
                    $tempArray[0][$key2] = 'v';
                    $tempArray[$key][$key2] = '.';
                    $moved = 1;
                }
            }
        }
    }

    $gridArray = $tempArray;
    if($moved == 0) {
        $notMovedStep = $steps;
        break;
    }
//    echo "Step $steps<br>";
//    printGrid($gridArray);

}

echo "<br><br>";
printGrid($gridArray);

$notMovedStep++;


echo "Day 25 Part A: Not moved after ".$notMovedStep." steps<br><br>\n";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";