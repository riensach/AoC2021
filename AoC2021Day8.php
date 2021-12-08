<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-4);
$puzzleInput = require 'input/'.$fileName.'.php';


//$puzzleInput = "be cfbegad cbdgef fgaecd cgeb fdcge agebfd fecdb fabcd edb | fdgacbe cefdb cefbgd gcbe
//edbfga begcd cbg gc gcadebf fbgde acbgfd abcde gfcbed gfec | fcgedb cgb dgebacf gc
//fgaebd cg bdaec gdafb agbcfd gdcbef bgcad gfac gcb cdgabef | cg cg fdcagb cbg
//fbegcd cbd adcefb dageb afcb bc aefdc ecdab fgdeca fcdbega | efabcd cedba gadfec cb
//aecbfdg fbg gf bafeg dbefa fcge gcbea fcaegb dgceab fcbdga | gecf egdcabf bgf bfgea
//fgeab ca afcebg bdacfeg cfaedg gcfdb baec bfadeg bafgc acf | gebdcfa ecba ca fadegcb
//dbcfg fgd bdegcaf fgec aegbdf ecdfab fbedc dacgb gdcebf gf | cefg dcbef fcge gbcadfe
//bdfegc cbegaf gecbf dfcage bdacg ed bedf ced adcbefg gebcd | ed bcgafe cdgba cbgef
//egadfb cdbfeg cegd fecab cgb gbdefca cg fgcdab egfdb bfceg | gbdfcae bgc cg cgb
//gcafb gcf dcaebfg ecagb gf abcdeg gaef cafbge fdbac fegbdc | fgae cfgab fg bagce";

$inputArray = explode("\n",$puzzleInput);


foreach($inputArray as $key => $value) {

    $values = explode(" | ",$value);

    $signal = explode(" ",$values[0]);
    $output = explode(" ",$values[1]);

    $signalArray[] = $signal;
    $outputArray[] = $output;

}

$pattern[0] = array(0=>'a',1=>'b',2=>'c',3=>'e',4=>'f',5=>'g');
$pattern[1] = array(0=>'c',1=>'f');
$pattern[2] = array(0=>'a',1=>'c',2=>'d',3=>'e',4=>'g');
$pattern[3] = array(0=>'a',1=>'c',2=>'d',3=>'f',4=>'g');
$pattern[4] = array(0=>'b',1=>'c',2=>'d',3=>'f');
$pattern[5] = array(0=>'a',1=>'b',2=>'d',3=>'f',4=>'g');
$pattern[6] = array(0=>'a',1=>'b',2=>'d',3=>'e',4=>'f',5=>'g');
$pattern[7] = array(0=>'a',1=>'c',2=>'f');
$pattern[8] = array(0=>'a',1=>'b',2=>'c',3=>'d',4=>'e',5=>'f',6=>'g');
$pattern[9] = array(0=>'a',1=>'b',2=>'c',3=>'d',4=>'f',5=>'g');

// 1, 4, 7, 8
$count0 = 0;
$count1 = 0;
$count2 = 0;
$count3 = 0;
$count4 = 0;
$count5 = 0;
$count6 = 0;
$count7 = 0;
$count8 = 0;
$count9 = 0;

//var_dump($outputArray);
foreach($outputArray as $key => $value) {
    foreach($value as $key2 => $value2) {
        $values = str_split($value2,1);
        //asort($values);
        //var_dump($pattern[1]);
        //var_dump($values);
        $valueCount = count($values);
        $valueCount = strlen($value2);
        //echo "$value2 - $valueCount<br>";
        if($valueCount==2){
            $count1++;
        }
        if($valueCount==4){
            $count4++;
        }
        if($valueCount==3){
            $count7++;
        }
        if($valueCount==7){
            $count8++;
        }
        //echo "<br>";
//        if($pattern[1]==$values){
//            $count1++;
//        }
//        if($pattern[4]==$values){
//            $count4++;
//        }
//        if($pattern[7]==$values){
//            $count7++;
//        }
//        if($pattern[8]==$values){
//            $count8++;
//        }
    }
}
//echo "$count1 + $count4 + $count7 + $count8<br>";
$partASum = $count1 + $count4 + $count7 + $count8;


echo "Day 8 Part A: Least fuel used was ".$partASum."<br>";


$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";