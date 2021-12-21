<?php

$time_pre = microtime(true);
$fileName = substr(basename(__FILE__, '.php'),-5);
$puzzleInput = require 'input/'.$fileName.'.php';

$puzzleInput = "[1,2]
[[1,2],3]
[9,[8,7]]
[[1,9],[8,5]]
[[[[1,2],[3,4]],[[5,6],[7,8]]],9]
[[[9,[3,8]],[[0,9],6]],[[[3,7],[4,9]],3]]
[[[[1,3],[5,3]],[[1,3],[8,7]]],[[[4,9],[6,9]],[[8,2],[7,3]]]]";

$inputArray = explode("\n",$puzzleInput);

$strPos = 0;
$treeArray = array();
foreach($inputArray as $key => $value) {
    $strPos = 0;
    $depth = 0;
    $charValues = str_split($value, 1);
    $treeArray[$key] = array();
    foreach($charValues as $key2 => $value2) {
        if($value2 == '[') {
            $depth++;
        } elseif($value2 == ']') {
            $depth--;
        }
        if(is_numeric($value2)) {
            $treeArray[$key][$depth][][$key2] = $value2;
        }

    }

    //die();
}

var_dump($treeArray);


foreach($treeArray as $key => $value) {
    $exploded = 0;
    $split = 0;
    while($split > 0 || $exploded > 0) {
        $exploded = 0;
        $split = 0;
        if(isset($treeArray[$key][4])) {
            // There's a 4th tier - so we explode
            $exploded = 1;
            $firstKey = array_key_first($treeArray[$key][4][0]);
            $secondKey = array_key_first($treeArray[$key][4][1]);
            $firstValue = $treeArray[$key][4][0][$firstKey];
            $secondValue = $treeArray[$key][4][1][$secondValue];

            // Add to a suitable value#
            $checkValue = $firstKey - 2;
            while($checkValue > 0) {
                foreach($treeArray[$key][3] as $key2 => $value2) {
                    if(isset($treeArray[$key][3][$key2][$checkValue])) {
                        $treeArray[$key][3][$key2][$checkValue] = $treeArray[$key][3][$key2][$checkValue] + $firstValue;
                        break;
                    }
                }
                foreach($treeArray[$key][2] as $key2 => $value2) {
                    if(isset($treeArray[$key][2][$key2][$checkValue])) {
                        $treeArray[$key][2][$key2][$checkValue] = $treeArray[$key][2][$key2][$checkValue] + $firstValue;
                        break;
                    }
                }
                foreach($treeArray[$key][1] as $key2 => $value2) {
                    if(isset($treeArray[$key][1][$key2][$checkValue])) {
                        $treeArray[$key][1][$key2][$checkValue] = $treeArray[$key][1][$key2][$checkValue] + $firstValue;
                        break;
                    }
                }
                $checkValue--;
            }

            $checkValue = $secondKey + 2;
            while($checkValue < 100) {
                foreach($treeArray[$key][3] as $key2 => $value2) {
                    if(isset($treeArray[$key][3][$key2][$checkValue])) {
                        $treeArray[$key][3][$key2][$checkValue] = $treeArray[$key][3][$key2][$checkValue] + $secondValue;
                        break;
                    }
                }
                foreach($treeArray[$key][2] as $key2 => $value2) {
                    if(isset($treeArray[$key][2][$key2][$checkValue])) {
                        $treeArray[$key][2][$key2][$checkValue] = $treeArray[$key][2][$key2][$checkValue] + $secondValue;
                        break;
                    }
                }
                foreach($treeArray[$key][1] as $key2 => $value2) {
                    if(isset($treeArray[$key][1][$key2][$checkValue])) {
                        $treeArray[$key][1][$key2][$checkValue] = $treeArray[$key][1][$key2][$checkValue] + $secondValue;
                        break;
                    }
                }
                $checkValue++;
            }
            unset($treeArray[$key][4][0][$firstKey]);
            unset($treeArray[$key][4][1][$secondKey]);
            $treeArray[$key][3][][$firstKey] = 0;
            usort($treeArray[$key][3], function ($a, $b) {
                $currKey = key($a);
                $currKey2 = key($a);
                return $a[$currKey]['key'] <=> $b[$currKey2]['key'];
            });
            usort($treeArray[$key][4], function ($a, $b) {
                $currKey = key($a);
                $currKey2 = key($a);
                return $a[$currKey]['key'] <=> $b[$currKey2]['key'];
            });
            //$treeArray[$key][4] = array_map('array_values', $treeArray[$key][4]);
            //$treeArray[$key][3] = array_map('array_values', $treeArray[$key][3]);
        }
        if(isset($treeArray[$key][1])) {
            // Check for a split
            foreach($treeArray[$key][1] as $key2 => $value2) {
                foreach($key2 as $key3 => $value3) {
                    if($value3 > 9) {
                        $split = 1;
                        $leftNumber = floor($value3 / 2);
                        $rightNumber = ceil($value3 / 2);

                        $treeArray[$key][2][$key3][] = $leftNumber;
                        $treeArray[$key][2][($key3+2)][] = $rightNumber;
                        unset($treeArray[$key][1][$key2][$key3]);


                        usort($treeArray[$key][1], function ($a, $b) {
                            $currKey = key($a);
                            $currKey2 = key($a);
                            return $a[$currKey]['key'] <=> $b[$currKey2]['key'];
                        });
                        usort($treeArray[$key][2], function ($a, $b) {
                            $currKey = key($a);
                            $currKey2 = key($a);
                            return $a[$currKey]['key'] <=> $b[$currKey2]['key'];
                        });
                        $treeArray[$key][1] = array_map('array_values', $treeArray[$key][1]);
                    }
                }
            }
        }
        if(isset($treeArray[$key][2])) {
            // Check for a split
            foreach($treeArray[$key][2] as $key2 => $value2) {
                foreach($key2 as $key3 => $value3) {
                    if($value3 > 9) {
                        $split = 1;
                        $leftNumber = floor($value3 / 2);
                        $rightNumber = ceil($value3 / 2);

                        $treeArray[$key][3][$key3][] = $leftNumber;
                        $treeArray[$key][3][($key3+2)][] = $rightNumber;
                        unset($treeArray[$key][2][$key2][$key3]);


                        usort($treeArray[$key][2], function ($a, $b) {
                            $currKey = key($a);
                            $currKey2 = key($a);
                            return $a[$currKey]['key'] <=> $b[$currKey2]['key'];
                        });
                        usort($treeArray[$key][3], function ($a, $b) {
                            $currKey = key($a);
                            $currKey2 = key($a);
                            return $a[$currKey]['key'] <=> $b[$currKey2]['key'];
                        });
                        $treeArray[$key][2] = array_map('array_values', $treeArray[$key][2]);
                    }
                }
            }
        }
        if(isset($treeArray[$key][3])) {
            // Check for a split
            foreach($treeArray[$key][3] as $key2 => $value2) {
                foreach($key2 as $key3 => $value3) {
                    if($value3 > 9) {
                        $split = 1;
                        $leftNumber = floor($value3 / 2);
                        $rightNumber = ceil($value3 / 2);

                        $treeArray[$key][4][$key3][] = $leftNumber;
                        $treeArray[$key][4][($key3+2)][] = $rightNumber;
                        unset($treeArray[$key][3][$key2][$key3]);


                        usort($treeArray[$key][3], function ($a, $b) {
                            $currKey = key($a);
                            $currKey2 = key($a);
                            return $a[$currKey]['key'] <=> $b[$currKey2]['key'];
                        });
                        usort($treeArray[$key][4], function ($a, $b) {
                            $currKey = key($a);
                            $currKey2 = key($a);
                            return $a[$currKey]['key'] <=> $b[$currKey2]['key'];
                        });
                        $treeArray[$key][3] = array_map('array_values', $treeArray[$key][3]);
                    }
                }
            }
        }
    }


}

var_dump($treeArray);
echo "<br>";

echo "Day 16 Part A: Summary of version numbers ".$versionNumbers."<br><br>";


$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
echo "Spent $exec_time seconds so far<br>";