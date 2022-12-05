<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "on x=-20..26,y=-36..17,z=-47..7
//on x=-20..33,y=-21..23,z=-26..28
//on x=-22..28,y=-29..23,z=-38..16
//on x=-46..7,y=-6..46,z=-50..-1
//on x=-49..1,y=-3..46,z=-24..28
//on x=2..47,y=-22..22,z=-23..27
//on x=-27..23,y=-28..26,z=-21..29
//on x=-39..5,y=-6..47,z=-3..44
//on x=-30..21,y=-8..43,z=-13..34
//on x=-22..26,y=-27..20,z=-29..19
//off x=-48..-32,y=26..41,z=-47..-37
//on x=-12..35,y=6..50,z=-50..-2
//off x=-48..-32,y=-32..-16,z=-15..-5
//on x=-18..26,y=-33..15,z=-7..46
//off x=-40..-22,y=-38..-28,z=23..41
//on x=-16..35,y=-41..10,z=-47..6
//off x=-32..-23,y=11..30,z=-14..3
//on x=-49..-5,y=-3..45,z=-29..18
//off x=18..30,y=-20..-8,z=-3..13
//on x=-41..9,y=-7..43,z=-33..15
//on x=-54112..-39298,y=-85059..-49293,z=-27449..7877
//on x=967..23432,y=45373..81175,z=27513..53682";

//$puzzleInput = "on x=10..12,y=10..12,z=10..12
//on x=11..13,y=11..13,z=11..13
//off x=9..11,y=9..11,z=9..11
//on x=10..10,y=10..10,z=10..10";

$inputArray = explode("\n",$puzzleInput);

$dataArray = array();
$gridMinWidth = 0;
$gridMaxWidth = 0;
$gridMinLength = 0;
$gridMaxLength = 0;
$gridMinHeight = 0;
$gridMaxHeight = 0;
foreach($inputArray as $key => $value) {
    $value = explode(" ",$value);
    $status = $value[0];
    $coords = explode(",",$value[1]);
    $xCord = str_replace("x=", "", $coords[0]);
    $yCord = str_replace("y=", "", $coords[1]);
    $zCord = str_replace("z=", "", $coords[2]);
    $xCordSplit = explode("..",$xCord);
    $yCordSplit = explode("..",$yCord);
    $zCordSplit = explode("..",$zCord);
    if($xCordSplit[0] < $gridMinWidth){
        $gridMinWidth = $xCordSplit[0];
    }
    if($xCordSplit[1] > $gridMaxWidth){
        $gridMaxWidth = $xCordSplit[1];
    }
    if($yCordSplit[0] < $gridMinLength){
        $gridMinLength = $yCordSplit[0];
    }
    if($yCordSplit[1] > $gridMaxLength){
        $gridMaxLength = $xCordSplit[1];
    }
    if($zCordSplit[0] < $gridMinHeight){
        $gridMinHeight = $zCordSplit[0];
    }
    if($zCordSplit[1] > $gridMaxHeight){
        $gridMaxHeight = $zCordSplit[1];
    }
    $dataArray[] = array('status' => $status, 'xCordStart' => $xCordSplit[0], 'xCordEnd' => $xCordSplit[1], 'yCordStart' => $yCordSplit[0], 'yCordEnd' => $yCordSplit[1], 'zCordStart' => $zCordSplit[0], 'zCordEnd' => $zCordSplit[1]);
}

$infoArray = array();

echo "$gridMinWidth : $gridMaxWidth : $gridMinLength : $gridMaxLength : $gridMinHeight : $gridMaxHeight<br>";

$gridMinWidth = -50;
$gridMaxWidth = 50;
$gridMinLength = -50;
$gridMaxLength = 50;
$gridMinHeight = -50;
$gridMaxHeight = 50;

for ($x = $gridMinWidth; $x <= $gridMaxWidth; $x++) {
    for ($y = $gridMinLength; $y <= $gridMaxLength; $y++) {
        for ($z = $gridMinHeight; $z <= $gridMaxHeight; $z++) {
            $infoArray[$x][$y][$z] = '.';
        }
    }
}

foreach($dataArray as $key => $values) {
    for ($x = $values['xCordStart']; $x <= $values['xCordEnd']; $x++) {
        if($x < $gridMinWidth || $x > $gridMaxWidth) {
            break;
        }
        for ($y = $values['yCordStart']; $y <= $values['yCordEnd']; $y++) {
            if($y < $gridMinLength || $y > $gridMaxLength) {
                break;
            }
            for ($z = $values['zCordStart']; $z <= $values['zCordEnd']; $z++) {
                if($z < $gridMinHeight || $z > $gridMaxHeight) {
                    break;
                }
                $validRange = false;
                if($values['xCordStart'] >= $gridMinWidth && $values['xCordEnd'] <= $gridMaxWidth && $values['yCordStart'] >= $gridMinLength && $values['yCordEnd'] <= $gridMaxLength && $values['xCordStart'] >= $gridMinHeight && $values['xCordStart'] <= $gridMaxHeight) {
                    $validRange = true;
                }
                if($validRange && $values['status'] == 'on') {
                    $infoArray[$x][$y][$z] = '#';
                } else {
                    $infoArray[$x][$y][$z] = '.';
                }
            }
        }
    }
}
$totalOnCubes = 0;
foreach($infoArray as $key => $values) {
    foreach($values as $key2 => $values2) {
        foreach($values2 as $key3 => $values3) {
            if($values3 == '#') {
                $totalOnCubes++;
            }
        }
    }
}

var_dump($dataArray);



echo "Day 22 Part A: Total lit cubes ".$totalOnCubes."<br><br>\n";
echo "Day 21 Part B: Total lit pixels ".$lightPixelsPartB."<br><br>\n";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";