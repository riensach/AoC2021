<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-6);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "620080001611562C8802118E34";
//$puzzleInput = "EE00D40C823060";
//$puzzleInput = "A0016C880162017C3686B18A3D4780";
//$puzzleInput = "CE00C43D881120";

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

$binaryMessage = '';

foreach($inputArray as $key => $value) {
    $binaryValue = $translationArray[$value];
    $binaryMessage .= $binaryValue;
}

function iterateBits (&$binaryMessage, &$strPos, &$versionArray) {
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
            $currentStrValue = substr($binaryMessage, $strPos, 1);
        }
        $valueNumeric = bindec($packetValue);
        $versionArray[] = $version;
        return $valueNumeric;
    } else {
        $lengthTypeID = bindec(substr($binaryMessage, $strPos, 1));
        $strPos++;
        if($lengthTypeID == 1) {
            $subpacketCount = bindec(substr($binaryMessage, $strPos, 11));
            $strPos = $strPos + 11 ;
            for($x = 0; $x < $subpacketCount; $x++) {
                $values[] = iterateBits($binaryMessage, $strPos, $versionArray);
            }
            $versionArray[] = $version;
        } else {
            $subpacketLength = bindec(substr($binaryMessage, $strPos, 15));
            $strPos = $strPos + 15;
            $endSubPacketLength = $strPos + $subpacketLength;
            for($x = 0; $x < $endSubPacketLength; $x++) {
                $values[] = iterateBits($binaryMessage, $strPos, $versionArray);
                $x = $strPos;
            }
            $versionArray[] = $version;
        }
        if($typeID == 0) {
            return array_sum($values);
        } elseif($typeID == 1) {
            return array_product($values);
        } elseif($typeID == 2) {
            return min($values);
        } elseif($typeID == 3) {
            return max($values);
        } elseif($typeID == 5) {
            return $values[0] > $values[1] ? 1:0;
        } elseif($typeID == 6) {
            return $values[1] > $values[0] ? 1:0;
        } elseif($typeID == 7) {
            return $values[1] == $values[0] ? 1:0;
        }
    }
}

$strPos = 0;
$versionArray = array();

$finalValue = iterateBits ($binaryMessage, $strPos,$versionArray);
$versionNumbers = array_sum($versionArray);

echo "Day 15 Part A: Summary of version numbers ".$versionNumbers."<br><br>";
echo "Day 16 Part B: Complete evaluation ".$finalValue."<br><br>";

$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";