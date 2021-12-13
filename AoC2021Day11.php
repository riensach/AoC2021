<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "5483143223
//2745854711
//5264556173
//6141336146
//6357385478
//4167524645
//2176841721
//6882881134
//4846848554
//5283751526";

$inputArray = explode("\n",$puzzleInput);

$flashCount = 0;
$octopus = array();
foreach($inputArray as $key => $value) {
    $octopusEnergy = str_split($value,1);
    foreach($octopusEnergy as $key2 => $value2) {
        $octopus[$key][$key2] = $value2;

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

$steps = 2000;
for ($x = 0; $x < $steps; $x++) {

    foreach($octopus as $key => $value) {
        foreach($value as $key2 => $value2) {
            $octopus[$key][$key2] = $octopus[$key][$key2] + 1;
        }
    }

    $foundOctopus = 1;
    while($foundOctopus > 0) {
        $flashFound = 0;
        foreach ($octopus as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if ($octopus[$key][$key2] > 9) {
                    $flashFound = 1;
                    //Flash!
                    $flashCount++;
                    $octopus[$key][$key2] = '0';
                    if (isset($octopus[$key - 1][$key2]) && $octopus[$key - 1][$key2] > 0) {
                        $octopus[$key - 1][$key2] = $octopus[$key - 1][$key2] + 1;
                    }

                    if (isset($octopus[$key + 1][$key2]) && $octopus[$key + 1][$key2] > 0) {
                        $octopus[$key + 1][$key2] = $octopus[$key + 1][$key2] + 1;
                    }
                    if (isset($octopus[$key][$key2 - 1]) && $octopus[$key][$key2 - 1] > 0) {
                        $octopus[$key][$key2 - 1] = $octopus[$key][$key2 - 1] + 1;
                    }

                    if (isset($octopus[$key][$key2 + 1]) && $octopus[$key][$key2 + 1] > 0) {
                        $octopus[$key][$key2 + 1] = $octopus[$key][$key2 + 1] + 1;
                    }

                    if (isset($octopus[$key - 1][$key2 - 1]) && $octopus[$key - 1][$key2 - 1] > 0) {
                        $octopus[$key - 1][$key2 - 1] = $octopus[$key - 1][$key2 - 1] + 1;
                    }

                    if (isset($octopus[$key + 1][$key2 + 1]) && $octopus[$key + 1][$key2 + 1] > 0) {
                        $octopus[$key + 1][$key2 + 1] = $octopus[$key + 1][$key2 + 1] + 1;
                    }
                    if (isset($octopus[$key - 1][$key2 + 1]) && $octopus[$key - 1][$key2 + 1] > 0) {
                        $octopus[$key - 1][$key2 + 1] = $octopus[$key - 1][$key2 + 1] + 1;
                    }
                    if (isset($octopus[$key + 1][$key2 - 1]) && $octopus[$key + 1][$key2 - 1] > 0) {
                        $octopus[$key + 1][$key2 - 1] = $octopus[$key + 1][$key2 - 1] + 1;
                    }


                }

            }
        }
        if($flashFound == 0) {
            break;
        }
    }
    $currentEnergy = 0;
    foreach($octopus as $key => $value) {

        $currentEnergy += array_sum($octopus[$key]);

    }

    if($currentEnergy == 0) {
        $x++;
        break;
    }
    //echo "After $x step, there is $currentEnergy energy<br>";

}




echo "Day 11 Part A: There are the following number of flashes ".$flashCount."<br>";
echo "Day 11 Part B: Total steps to sync is is ".$x."<br>";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";