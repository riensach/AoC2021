<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';

//
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


function identifyPattern($signalInput) {
    $patterns = array();
    $top = '';
    $topleft = '';
    $topright = '';
    $middle = '';
    $bottomleft = '';
    $bottomright = '';
    $bottom = '';
    // 0 => 6
    // 2 => 5
    // 3 => 5
    // 5 => 5
    // 6 => 6
    // 9 => 6

    foreach($signalInput as $key => $value) {
        $length = strlen($value);
        if($length==2) {
            // We know this is 1
            $patterns[1] = str_split($value,1);
        } elseif($length==4) {
            // We know this is 4
            $patterns[4] = str_split($value,1);
        } elseif($length==3) {
            // We know this is 7
            $patterns[7] = str_split($value,1);
        } elseif($length==7) {
            // We know this is 8
            $patterns[8] = str_split($value,1);
        } elseif($length==6) {
            // We know this *could* be 0, 6, 9
            $option0[] = str_split($value,1);
            $option6[] = str_split($value,1);
            $option9[] = str_split($value,1);
            //$patterns[8] = str_split($value,1);
        } elseif($length==5) {
            // We know this *could* be 2, 3, 5
            $option2[] = str_split($value,1);
            $option3[] = str_split($value,1);
            $option5[] = str_split($value,1);
            //$patterns[8] = str_split($value,1);
        }
    }

    $findingTop = array_diff($patterns[7], $patterns[4]);
    $top = $findingTop[array_key_first($findingTop)];

    $findingTopRight = array_diff($patterns[1], array_intersect($option0[0], $option0[1], $option0[2]));
    $topright = $findingTopRight[array_key_first($findingTopRight)];

    $findingBottomRight = array_diff($patterns[1], $findingTopRight);
    $bottomright = $findingBottomRight[array_key_first($findingBottomRight)];
//    var_dump($top);
//    var_dump($topright);
//    var_dump($bottomright);




    $testfor2a = array_intersect($option2[0], $findingBottomRight);
    $testfor2b = array_intersect($option2[1], $findingBottomRight);
    $testfor2c = array_intersect($option2[2], $findingBottomRight);
    $testfor3a = array_intersect($option2[0], $findingTopRight);
    $testfor3b = array_intersect($option2[1], $findingTopRight);

    if(empty($testfor2a)) {
        // This is pattern 2
        $patterns[2] = $option2[0];
        if(empty($testfor3b)) {
            // This is option 5
            $patterns[5] = $option2[1];
            $patterns[3] = $option2[2];
        } else {
            // This is option 3
            $patterns[3] = $option2[1];
            $patterns[5] = $option2[2];
        }
    } elseif(empty($testfor2b)) {
        // This is pattern 2
        $patterns[2] = $option2[1];
        if(empty($testfor3a)) {
            // This is option 5
            $patterns[5] = $option2[0];
            $patterns[3] = $option2[2];
        } else {
            // This is option 3
            $patterns[3] = $option2[0];
            $patterns[5] = $option2[2];
        }
    } elseif(empty($testfor2c)) {
        // This is pattern 2
        $patterns[2] = $option2[2];
        if(empty($testfor3a)) {
            // This is option 5
            $patterns[5] = $option2[0];
            $patterns[3] = $option2[1];
        } else {
            // This is option 3
            $patterns[3] = $option2[0];
            $patterns[5] = $option2[1];
        }
    } else {
        echo "how did we get here?<Br>";
    }


    // At this point I know:
    // Top, Top Right, Bottom right
    // Pattern 1, 2, 3, 4, 5, 7, 8
    // Outstanding: 0, 6, 9


    // 0 6 9



    $findingTopLeft = array_diff($patterns[4], array_merge($patterns[2], $patterns[1]));
    $topleft = $findingTopLeft[array_key_first($findingTopLeft)];


    $findingMiddle = array_diff($patterns[4], array_merge($patterns[1], $findingTopLeft));
    $middle = $findingMiddle[array_key_first($findingMiddle)];

    // HERE IS THE PROBLEM
    //

    //var_dump($findingMiddle);


    $testfor6a = array_intersect($option0[0], $findingTopRight);
    $testfor6b = array_intersect($option0[1], $findingTopRight);
    $testfor6c = array_intersect($option0[2], $findingTopRight);
    $testfor0a = array_intersect($option0[0], $findingMiddle);
    $testfor0b = array_intersect($option0[1], $findingMiddle);

    if(empty($testfor6a)) {
        // This is pattern 6
        $patterns[6] = $option0[0];
        if(empty($testfor0b)) {
            // This is option 0
            $patterns[0] = $option0[1];
            $patterns[9] = $option0[2];
        } else {
            // This is option 9
            $patterns[9] = $option0[1];
            $patterns[0] = $option0[2];
        }
    } elseif(empty($testfor6b)) {
        // This is pattern 6
        $patterns[6] = $option0[1];
        if(empty($testfor0a)) {
            // This is option 0
            $patterns[0] = $option0[0];
            $patterns[9] = $option0[2];
        } else {
            // This is option 9
            $patterns[9] = $option0[0];
            $patterns[0] = $option0[2];
        }
    } elseif(empty($testfor6c)) {
        // This is pattern 6
        $patterns[6] = $option0[2];
        if(empty($testfor0a)) {
            // This is option 0
            $patterns[0] = $option0[0];
            $patterns[9] = $option0[1];
        } else {
            // This is option 9
            $patterns[9] = $option0[0];
            $patterns[0] = $option0[1];
        }
    } else {
        echo "how did we get here?<Br>";
    }








   // var_dump($patterns);



    $findingBottom = array_diff($patterns[8], $patterns[1], $patterns[4], $patterns[7]);
   // var_dump($findingBottom);
    $findingLeftMidMid = array_diff($patterns[4], $patterns[1], $patterns[7]);
   // var_dump($findingLeftMidMid);





    $findingTopLeft = array_diff($patterns[1], $patterns[6]);
    $topleft = $findingTopLeft[array_key_first($findingTopLeft)];
   // var_dump($findingTop);


  //  die();


   // var_dump($patterns);
    return $patterns;
}
$outputValue = 0;
foreach($signalArray as $key => $signalInput) {

//var_dump($signalInput);
    $patterns = identifyPattern($signalInput);
    $value = '';
    foreach($outputArray[$key] as $key2 => $outputValues) {

        $values = str_split($outputValues,1);
        //var_dump($values);
        //var_dump($patterns);
        foreach($patterns as $key3 => $pattern) {
            $result = array_diff($values, $pattern);
            $result2 = array_diff($pattern, $values);
            //var_dump($values);
            //var_dump($pattern);
//            var_dump($result);
//            echo "<br>";
            if(empty($result) && empty($result2)){
                // Found the pattern
                //echo "found it - $key3<br>";
                $value .= "$key3";
            }
        }
    }
    echo "adding $value to $outputValue<br>";
    $outputValue += (int)$value;

}



echo "Day 8 Part B: Least fuel used was ".$outputValue."<br>";


$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";