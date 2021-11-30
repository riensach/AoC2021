<?php
$puzzleInput = "";
$time_pre = microtime(true);







$inputArray = explode("\n",$puzzleInput);


$done1 = $done2 = 0;
foreach($inputArray as $key => $value) {
    foreach($inputArray as $key2 => $value2) {
        $totalValue = (int)$value + (int)$value2;
        if ($totalValue == 2020) {
            $endValue1 = (int) $value * (int)$value2;
            $done1 = 1;
        }
        foreach($inputArray as $key3 => $value3) {
            $totalValue = (int)$value + (int)$value2 + (int)$value3;
            if ($totalValue == 2020) {
                $endValue2 = (int)$value * (int)$value2 * (int)$value3;

                $done2 = 1;
            }
            if($done1==1 && $done2==1) {
                break 3;
            }
        }
    }
}

echo "Day 1 Part A: ".$endValue1."<br>";
echo "Day 1 Part B: ".$endValue2."<br>";











$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";
