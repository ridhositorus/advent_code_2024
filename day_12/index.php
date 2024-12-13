<?php

$sample = "AAAA
BBCD
BBCC
EEEC";

$sample2 = "OOOOO
OXOXO
OOOOO
OXOXO
OOOOO";

$sample3 = "RRRRIICCFF
RRRRIICCCF
VVRRRCCFFF
VVRCCCJFFF
VVVVCJJCFE
VVIVCCJJEE
VVIIICJJEE
MIIIIIJJEE
MIIISIJEEE
MMMISSJEEE";

$sampleArr = explode("\n", $sample3);

$merged = [];

function addNewObject($foundObject, $name, $cordinates)
{
  $foundObject[$name] = [];
  foreach ($cordinates as $corItem)
  {
    echo "<br>-- Register $corItem to $name";
    $foundObject[$name][] = $corItem;
  }
  return $foundObject;
}

function getObjectKey($foundObject, $searchValue)
{
  foreach ($foundObject as $key => $valueArr)
  {
    if (in_array($searchValue, $valueArr))
    {
      return $key;
    }
  }
  return false;
}

$foundObject = [];
$modifiedObject = [];
$objectCounter = 0;
function checkSurroundingValue($foundObject, $currentCordinate, $currentObjectKey, $surroundingCordinate, $position, $maxColumnIndex = 0): array
{

  $surroundingObjectKey = getObjectKey($foundObject, $surroundingCordinate);
//  echo "<br>$position found with key $surroundingCordinate found which registered in $surroundingObjectKey. Current object key : $currentObjectKey";
  if ($currentObjectKey !== false && $surroundingObjectKey === false)
  {
    $foundObject[$currentObjectKey][] = $surroundingCordinate;

  }
  elseif ($currentObjectKey === false && $surroundingObjectKey !== false)
  {
    $foundObject[$surroundingObjectKey][] = $currentCordinate;
    $currentObjectKey = $surroundingObjectKey;
  }
  elseif ($currentObjectKey === false && $surroundingObjectKey === false)
  {
    $objectCounter = count($foundObject) + 1;
    $objectKeyName = "Object-$objectCounter";

    $foundObject = addNewObject($foundObject, $objectKeyName, [$currentCordinate, $surroundingCordinate]);
    $currentObjectKey = $objectKeyName;
  }

  return [$foundObject, $currentObjectKey];
}

$newArr = [];
foreach ($sampleArr as $key => $sampleItem)
{
  $splitChar = str_split($sampleItem);
  $currentChar = "";

  echo "<hr>$sampleItem";
  foreach ($splitChar as $keyChar => $char)
  {
    $currentCordinate = "$key,$keyChar";
    $rightCordinate = "$key," . $keyChar + 1;
    $leftCordinate = "$key," . $keyChar - 1;
    $bottomCordinate = $key + 1 . ",$keyChar";
    $topCordinate = $key - 1 . ",$keyChar";

    echo "<br>-Char $char $currentCordinate";
    $currentObjectKey = getObjectKey($foundObject, $currentCordinate);
    if (count($foundObject) == 0)
    {
      $objectCounter++;
      echo "-- create new object : Object-$objectCounter";
      $currentObjectKey = "Object-$objectCounter";
      $foundObject[$currentObjectKey][] = $currentCordinate;
    }

    //check right
    $newArr["$key,$keyChar"] = [];
    if ($keyChar + 1 <= count($splitChar) - 1 && isset($sampleArr[$key][$keyChar + 1]) && $sampleArr[$key][$keyChar + 1] === $char)
    {
      $newArr["$key,$keyChar"][] = $rightCordinate;
      [$foundObject, $currentObjectKey] = checkSurroundingValue($foundObject, $currentCordinate, $currentObjectKey, $rightCordinate, "Right", count($splitChar));
    }

    if ($key + 1 <= count($sampleArr) - 1 && isset($sampleArr[$key + 1][$keyChar]) && $sampleArr[$key + 1][$keyChar] === $char)
    {
      $newArr["$key,$keyChar"][] = $bottomCordinate;
      [$foundObject, $currentObjectKey] = checkSurroundingValue($foundObject, $currentCordinate, $currentObjectKey, $bottomCordinate, "Bottom");
    }

    if ($key - 1 >= 0 && isset($sampleArr[$key - 1][$keyChar]) && $sampleArr[$key - 1][$keyChar] === $char)
    {
      $newArr["$key,$keyChar"][] = $topCordinate;
      [$foundObject, $currentObjectKey] = checkSurroundingValue($foundObject, $currentCordinate, $currentObjectKey, $topCordinate, "Top");
    }

    if ($keyChar - 1 >= 0 && isset($sampleArr[$key][$keyChar - 1]) && $sampleArr[$key][$keyChar - 1] === $char)
    {
      $newArr["$key,$keyChar"][] = $leftCordinate;
      [$foundObject, $currentObjectKey] = checkSurroundingValue($foundObject, $currentCordinate, $currentObjectKey, $leftCordinate, "Left");
    }

    //failsafe
    if ($currentObjectKey == false)
    {
      $objectCounter = count($foundObject) + 1;
      echo " #### top right bottom left not found, create new object : Object-$objectCounter";
      $currentObjectKey = "Object-$objectCounter";
      $foundObject[$currentObjectKey][] = $currentCordinate;
    }
  }
}
//
echo "<hr>";
//foreach ($foundObject as $item => $itemValue)
//{
//  echo "<br>Object $item. Count : " . count($itemValue);
//  echo "<br>Cordinate : " . implode(" ", $itemValue);
//}

//$newArrTemp = $newArr;
$skippedCordinate = [];
$mergedArr = [];
foreach ($newArr as $key1 => $sampleRow)
{
  $mergedArr[$key1][] = $key1;
//  echo "<br>Key : $key1";

  if (in_array($key1, $skippedCordinate)) {
//    echo "<br> Skipped ";
    continue;
  }
  foreach ($sampleRow as $key3 => $surrounding)
  {
    if (is_array($newArr[$surrounding]))
    {
      $mergedArr[$key1] = array_merge($mergedArr[$key1], $newArr[$surrounding]);
      $skippedCordinate[] = $surrounding;
    }
  }
//  echo "<br>Surrounding : " . implode(" ", array_unique($mergedArr[$key1]));
}

echo "Count result : " . count($mergedArr);
