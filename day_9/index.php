<?php

ini_set('max_execution_time', '0');


$startTime = microtime(true);

echo "<br>Start time : $startTime";
$sample = "2333133121414131402";

$sampleShort = "12345";
$realInput = file_get_contents('real_input.txt', true);
$sampleArr = str_split($sample);



$splittedArray = [];
$currStr = "";

$allChar = "";
$numberCount = 0;
$dotCordinate = [];
$numberCordinate = [];
foreach ($sampleArr as $key => $value)
{
  if ($key % 2 == 1) {
    $char = ".";
  }
  else
  {
    $char = $numberCount;
    $numberCount++;
  }
  $maxValue = intval($value);
  for ($i = 0; $i < (int)$maxValue; $i++)
  {
    if ($char == ".")
    {
      $dotCordinate[] = strlen($allChar);
    }
    else
    {
      $numberCordinate[] = strlen($allChar);
    }
    $allChar .= $char;
  }
}

echo "<br>Result : $allChar";

$numberIndex = strlen($allChar) -1;

echo "<br>Dot count : ".count($dotCordinate);
var_dump($dotCordinate);
foreach ($dotCordinate as $key => $value)
{
  $tempChar = $allChar;
  echo "<br>----- Value : $value";
//  echo "<br>Dot $value, Number ". $numberIndex;
//  $tempChar = str_split($tempChar);
  $dotCount = 0;
  for ($i = strlen($allChar) - 1; $i > 0; $i--)
  {
    $substr = substr($tempChar, $i, 1);
    if ($substr != ".")
    {
      $tempChar[$value] = $substr;
      $tempChar[$i] = ".";
      $allChar = $tempChar;
      break;
    }
    else
    {
//      $dotCount++;
//      if ($dotCount == count($dotCordinate)) {
//        echo "<br>Quit loop on key $key. val : $value. count : ".count($dotCordinate);
//        break;
//      }
    }
  }
  echo "<br>$allChar";
}
//exit();
//$allchar = $allChar;
//print_r($allchar);

$sum = 0;
for ($i = 0; $i <= strlen($allChar); $i++)
{
//  echo "<br>$i * $allChar[$i]";
  if ($allChar[$i] == 0) continue;
  $sum += ($i * $allChar[$i]);
  echo "<br>$i * $allChar[$i] : " . ($i * $allChar[$i]) . " --- Sum : $sum";
//
//  var_dump($allChar[$i]);
//  var_dump($allChar[$i+1]);
//  exit();
  if ($allChar[$i+1] == ".")
  {
    break;
  }
}

//$sum = (0 * $allchar[0]) + (1 * $allchar[1]) + (2 * $allchar[2]) + (3 * $allchar[3]) + (4 * $allchar[4]) + (5 * $allchar[5]);
echo "<br>Sum : " . $sum;
$endTime = microtime(true);
echo "<br>End time : $endTime";
$executionTime = $endTime - $startTime;
echo "<br>Execution time : $executionTime";




// 90328963761 too low
// 90328963761

