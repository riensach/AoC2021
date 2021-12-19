<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';

//$puzzleInput = "620080001611562C8802118E34";
//$puzzleInput = "EE00D40C823060";
//$puzzleInput = "A0016C880162017C3686B18A3D4780";
//$puzzleInput = "D2FE28";

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

//$version = substr($binaryMessage, 0, 3);
//$typeID = substr($binaryMessage, 3, 3);
//echo "<br>";
//echo "$version - $typeID<br>";
//$version = bindec($version);
//$typeID = bindec($typeID);
//echo "$version - $typeID<br>";


$strPos = 0;
$finished = 0;
$versionArray = array();
$strLength = strlen($binaryMessage);

function iterateBits (&$binaryMessage, $strPos, $strLength, &$versionArray) {
        $version = bindec(substr($binaryMessage, $strPos, 3));
        echo "Verions: $version<br>";
        $versionArray[] = $version;
        $typeID = bindec(substr($binaryMessage, $strPos+3, 3));
        $strPos = $strPos + 6;
        if($typeID == 4) {
            echo "Literal value<br>";
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
                //echo "$getPacketValue<br>";
                $currentStrValue = substr($binaryMessage, $strPos, 1);
            }
            //$currentStrValue = substr($binaryMessage, $strPos, 1);
//            while($currentStrValue == 0 && $strPos < strlen($binaryMessage)) {
//                $strPos++;
//                $currentStrValue = substr($binaryMessage, $strPos, 1);
//                echo "stuck here<Br>";
//            }
            $valueNumeric = bindec($packetValue);
            echo "Literal value: $packetValue - $valueNumeric - $strPos<br>";
        } else {
            echo "Operator<br>";
            $lengthTypeID = bindec(substr($binaryMessage, $strPos, 1));
            $strPos++;
            if($lengthTypeID == 1) {
                echo "Sub Packets 1: <br>";
                $subpacketCount = bindec(substr($binaryMessage, $strPos, 11));
                echo "Current position of $strPos - ";
                //$strPos = $strPos + 11 + (11*$subpacketCount);
                $strPos = $strPos + 11 ;
                //echo "Found $subpacketCount more packets. Skipping to strPos $strPos<br>";
                for($x = 0; $x < $subpacketCount; $x++) {
                    echo "<br>Looping sub-packets, total found of $subpacketCount<br>";
                    $strPos = iterateBits($binaryMessage, $strPos, $strLength, $versionArray);
                    //$strPos--;
                    //echo "String Position After: $strPos - <br>";
                }
                // Need to actually read the subpacket data - recursion required

            } else {
                echo "Sub Packets 2: <br>";
                $subpacketLength = bindec(substr($binaryMessage, $strPos, 15));
                $subpackets = substr($binaryMessage, $strPos+15, $subpacketLength);
                //echo "Current position of $strPos - $lengthTypeID - ";
                //$strPos = $strPos + 15 + $subpacketLength;
                $strPos = $strPos + 15;
                $endSubPacketLength = $strPos + $subpacketLength;
                for($x = 0; $x < $endSubPacketLength; $x++) {
                    $strPos = iterateBits($binaryMessage, $strPos, $strLength, $versionArray);
                    $x = $strPos;
                }
                //echo "Found $subpacketLength more packet bits. Skipping to strPos $strPos<br>";
            }

        }
        return $strPos;

}


iterateBits ($binaryMessage, $strPos, $strLength, $versionArray);


var_dump($versionArray);
$versionNumbers = array_sum($versionArray);







echo "Day 16 Part A: Summary of version numbers ".$versionNumbers."<br><br>";


$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";