<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';

$puzzleInput = "38006F45291200";
$puzzleInput = "D2FE28";
$puzzleInput = "38006F45291200";

$inputArray = str_split($puzzleInput, 1);


$translationArray = array(0 => '0000',
1 => '0001',
2 => '0010',
3 => '0011',
4 => '0100',
5 => '0101',
6 => '0110',
7 => '0111',
8 => '1000',
9 => '1001',
'A' => '1010',
'B' => '1011',
'C' => '1100',
'D' => '1101',
'E' => '1110',
'F' => '1111');

var_dump($translationArray);

$binaryMessage = '';

foreach($inputArray as $key => $value) {
    $binaryValue = $translationArray[$value];
    $binaryMessage .= $binaryValue;
    //echo "$value - $binaryValue - $binaryMessage<br>";
}
echo $binaryMessage;
echo "<br>";
$binaryMessage = rtrim($binaryMessage,'0');
echo $binaryMessage;
echo "<br>";

$version = substr($binaryMessage, 0, 3);
$typeID = substr($binaryMessage, 3, 3);
echo "<br>";
echo "$version - $typeID<br>";
$version = bindec($version);
$typeID = bindec($typeID);
echo "$version - $typeID<br>";


$strPos = 0;
$finished = 0;


while($finished < 1) {
    $version = bindec(substr($binaryMessage, $strPos, 3));
    $typeID = bindec(substr($binaryMessage, $strPos+3, 3));
    $strPos = $strPos + 6;
    if($typeID == 4) {
        $currentStrValue = substr($binaryMessage, $strPos, 1);
        $packetValue = '';
        $finishedLiteralLoop = 0;
        while($finishedLiteralLoop < 1) {
            if($currentStrValue == 0) {
                $finishedLiteralLoop = 1;
            }
            $strPos++;
            $getPacketValue = substr($binaryMessage, $strPos, 4);
            $packetValue .= $getPacketValue;
            $strPos = $strPos + 4;
            echo "$getPacketValue<br>";
            $currentStrValue = substr($binaryMessage, $strPos, 1);
        }
        $currentStrValue = substr($binaryMessage, $strPos, 1);
        while($currentStrValue == 0 && $strPos < strlen($binaryMessage)) {
            $strPos++;
            $currentStrValue = substr($binaryMessage, $strPos, 1);

            echo "stuck here<Br>";
        }
        $valueNumeric = bindec($packetValue);
        echo "$packetValue - $valueNumeric<br>";
    } else {
        $lengthTypeID = bindec(substr($binaryMessage, $strPos, 1));
        $strPos++;
        if($lengthTypeID == 1) {
            $subpacketCount = bindec(substr($binaryMessage, $strPos, 11));
        } else {
            $subpacketLength = bindec(substr($binaryMessage, $strPos, 15));
        }

    }

$finished = 1;

}










echo "Day 15 Part A: Lowest total risk ".$lowestRisk." in ".$numberOfMoves." moves<br>";
echo "Day 15 Part B: Lowest total moves? ".$lowestNumberOfMoves."<br>";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";