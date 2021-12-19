<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "start-A
//start-b
//A-c
//A-b
//b-d
//A-end
//b-end";

//$puzzleInput = "fs-end
//he-DX
//fs-he
//start-DX
//pj-DX
//end-zg
//zg-sl
//zg-pj
//pj-he
//RW-he
//fs-DX
//pj-RW
//zg-RW
//start-pj
//he-WI
//zg-he
//pj-fs
//start-RW";

$inputArray = explode("\n",$puzzleInput);

$caveLinks = array();
$caves = array();
$totalPaths = 0;

foreach($inputArray as $key => $value) {

    $values = explode("-",$value);
    if(ctype_upper($values[0])) {
        $case = 'upper';
    } else {
        $case = 'lower';
    }

    $caveLinks[] = array('linkFrom' => $values[0], 'linkTo' => $values[1], 'case' => $case);
    if(!in_array($values[0], $caves)) {
        $caves[] = $values[0];
    }
    if(!in_array($values[1], $caves)) {
        $caves[] = $values[1];
    }

}

$finished = 0;
$paths = array();
$stepInfo = array();

 // 18146 too low

function evaluatePath(&$paths, &$caves, &$caveLinks, $stepInfo, $currentCaveID, $specialModifier) {
    $endID = array_search('end', $caves);
    if($currentCaveID == $endID) {
        // Made it to the end
        //echo "MAde it to the end with this path:<br>";
        //var_dump($stepInfo);
        $paths[] = $stepInfo;
        return;
    }

    $currentCave = $caves[$currentCaveID];

    $destinationOptions = array_merge(array_keys(array_column($caveLinks, 'linkFrom'), $currentCave),array_keys(array_column($caveLinks, 'linkTo'), $currentCave));
    //var_dump($destinationOptions);

    $stepsSoFar = count($stepInfo);
    //$specialModifier = 0;
    foreach($destinationOptions as $key => $value) {
        $updatedSpecialModifier = $specialModifier;
        if($currentCave == $caveLinks[$value]['linkTo']) {
            //echo "Taking next step from $currentCave to ".$caveLinks[$value]['linkFrom']." - done $stepsSoFar so far <bR>";
            $newStepInfo = $stepInfo;
            $newStepInfo[] = array('from' => $currentCave, 'to' => $caveLinks[$value]['linkFrom']);
            $newCurrentCaveID = array_search($caveLinks[$value]['linkFrom'], $caves);
            //echo "New cave ID is $newCurrentCaveID;";
            $newCurrentCaveHistory = array_merge(array_keys(array_column($newStepInfo, 'from'), $caveLinks[$value]['linkFrom']),array_keys(array_column($newStepInfo, 'to'), $caveLinks[$value]['linkFrom']));
            //var_dump($newCurrentCaveHistory);
            if($caveLinks[$value]['linkFrom'] == 'start' && $currentCave <> 'start') {
               // echo "Trying to go back to start; ending now<br>";
                continue;
            } elseif(!ctype_upper($caveLinks[$value]['linkFrom']) && count($newCurrentCaveHistory) > 1 && $updatedSpecialModifier == 0) {
                $updatedSpecialModifier = 1;
               // echo "Trying to go back to a small cave for the first time, special disposition here<br>";
            } elseif(!ctype_upper($caveLinks[$value]['linkFrom']) && count($newCurrentCaveHistory) > 1) {
                //echo "Trying to go back to a small cave for the SECOND time, ending now<br>";
            // Been here before, exit path finding
            //echo "dead end, exit<Br>";
            continue;
            }
        } else {
            //echo "Taking next step from $currentCave to ".$caveLinks[$value]['linkTo']." - done $stepsSoFar so far<bR>";
            $newStepInfo = $stepInfo;
            $newStepInfo[] = array('from' => $currentCave, 'to' => $caveLinks[$value]['linkTo']);
            $newCurrentCaveID = array_search($caveLinks[$value]['linkTo'], $caves);
            //echo "New cave ID is $newCurrentCaveID;";
            $newCurrentCaveHistory = array_merge(array_keys(array_column($newStepInfo, 'from'), $caveLinks[$value]['linkTo']),array_keys(array_column($newStepInfo, 'to'), $caveLinks[$value]['linkTo']));
            //var_dump($newCurrentCaveHistory);
            if($caveLinks[$value]['linkTo'] == 'start' && $currentCave <> 'start') {
               // echo "Trying to go back to start; ending now<br>";
                continue;
            } elseif(!ctype_upper($caveLinks[$value]['linkTo']) && count($newCurrentCaveHistory) > 1 && $updatedSpecialModifier == 0) {
                $updatedSpecialModifier = 1;
               // echo "Trying to go back to a small cave for the first time, special disposition here<br>";
            } elseif(!ctype_upper($caveLinks[$value]['linkTo']) && count($newCurrentCaveHistory) > 1) {
               // echo "Trying to go back to a small cave for the SECOND time, ending now<br>";
            // Been here before, exit path finding
            //echo "dead end, exit<Br>";
            continue;
            }
        }
        evaluatePath($paths, $caves, $caveLinks, $newStepInfo, $newCurrentCaveID, $updatedSpecialModifier);
    }


}






$startID = array_search('start', $caves);

evaluatePath($paths, $caves, $caveLinks, $stepInfo, $startID, 0);


$totalPaths = count($paths);



//var_dump($caveLinks);
//var_dump($caves);
//var_dump($paths);
//var_dump($paths);



foreach($paths as $key => $value) {
   // echo "<br>start,";
    foreach($value as $key2 => $value2) {
      //  echo $value2['to'].",";
    }
}


//echo "<br>";




echo "Day 12 Part A: Total paths are ".$totalPaths."<br>";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";