<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';



$puzzleInput = "#############
#...........#
###B#C#B#D###
###A#D#C#A###
#############";

$inputArray = explode("\n",$puzzleInput);

$energyUseValues = array('A' => 1, 'B' => 10, 'C' => 100, 'D' => 1000);
$energyLocations = array();

$gridArray = array();


foreach($inputArray as $key => $value) {
    $valuesLocation = str_split($value,1);
    foreach($valuesLocation as $key2 => $value2) {
        $gridArray[$key][$key2] = $value2;
        if(ctype_alpha($value2)) {
            $energyLocations[] = array('value' => $key2, 'location' => $value2);
        }
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

printGrid($gridArray);

var_dump($energyLocations);



echo "Day 23 Part A: Total lit cubes ".$totalOnCubes."<br><br>\n";
echo "Day 23 Part B: Total lit pixels ".$lightPixelsPartB."<br><br>\n";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";