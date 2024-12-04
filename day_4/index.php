<?php

$realInput = file_get_contents('real_input.txt', true);

// Part 1 : 2642
// Part 2 : 1974

$sample = "MMMSXXMASM
MSAMXMSMSA
AMXSXMAAMM
MSAMASMSMX
XMASAMXAMM
XXAMMXXAMA
SMSMSASXSS
SAXAMASAAA
MAMMMXMMMM
MXMXAXMASX";

$sample = explode("\n", $realInput);

$newArray = [];
$columnArr = [];
$xmasFound = 0;
foreach ($sample as $row => $value) {
  $str = str_split($value);
  $currentString = "";
  foreach ($str as $column => $char) {
    // horizontal check
    $currentString .= $char;

    $columnArr[$column][] = $char;

    $newArray[$row][$column] = $char;
  }
  echo "<br>Row $row. String : $currentString";
  /** Part 1
  $xmasSearch = substr_count($currentString, "XMAS");
  $samxSearch = substr_count($currentString, "SAMX");
  $xmasFound += $xmasSearch+$samxSearch;
   */
}

function checkUpLeft($newArray, $currentRow, $currentColumn, $level)
{
  return isset($newArray[$currentRow-$level]) && isset($newArray[$currentRow-$level][$currentColumn-$level]) ? $newArray[$currentRow-$level][$currentColumn-$level] : "Q";
}

function checkUpRight($newArray, $currentRow, $currentColumn, $level)
{
  return isset($newArray[$currentRow-$level]) && isset($newArray[$currentRow-$level][$currentColumn+$level]) ? $newArray[$currentRow-$level][$currentColumn+$level] : "Q";
}

function checkBottomLeft($newArray, $currentRow, $currentColumn, $level)
{
  return isset($newArray[$currentRow+$level]) && isset($newArray[$currentRow+$level][$currentColumn-$level]) ? $newArray[$currentRow+$level][$currentColumn-$level] : "Q";
}

function checkBottomRight($newArray, $currentRow, $currentColumn, $level)
{
  return isset($newArray[$currentRow+$level]) && isset($newArray[$currentRow+$level][$currentColumn+$level]) ? $newArray[$currentRow+$level][$currentColumn+$level] : "Q";
}

// diagonal check
foreach ($newArray as $row => $value) {
  foreach ($value as $column => $char) {
    // Part 1 char = M
    if ($char == "A" && $row > 0 && $row < count($newArray)-1 && $column > 0 && $column < count($value)-1) {
      $upLeft = checkUpLeft($newArray, $row, $column, 1);
//      $upLeft2 = checkUpLeft($newArray, $row, $column, 2);
      $upRight = checkUpRight($newArray, $row, $column, 1);
//      $upRight2 = checkUpRight($newArray, $row, $column, 2);
      $bottomLeft = checkBottomLeft($newArray, $row, $column, 1);
//      $bottomLeft2 = checkBottomLeft($newArray, $row, $column, 2);
      $bottomRight = checkBottomRight($newArray, $row, $column, 1);
//      $bottomRight2 = checkBottomRight($newArray, $row, $column, 2);

      echo "<br>Current cordinate : $row, $column";
//      $str1 = $upLeft2 . $upLeft . $char . $bottomRight . $bottomRight2;
      $str1 = $upLeft . $char . $bottomRight;
      echo "<br>String 1 : $str1";
//      $str2 = $upRight2 . $upRight . $char . $bottomLeft . $bottomLeft2;
      $str2 = $upRight . $char . $bottomLeft;
      echo "<br>String 2 : $str2";

      $xmasSearch = substr_count($str1, "MAS");
      $samxSearch = substr_count($str1, "SAM");

      $found = 0;
      if ($xmasSearch + $samxSearch > 0) {
        $found++;
      }
      echo "--- Upleft. Found : $found";


      $xmasSearch = substr_count($str2, "MAS");
      $samxSearch = substr_count($str2, "SAM");

      if ($xmasSearch + $samxSearch > 0) {
        $found++;
      }
      echo "--- Upright. Found : $found";


      if ($found == 2) $xmasFound++;

      /** Part 1
      echo "---Upleft. Xmas : $xmasSearch, Samx : $samxSearch";
      $xmasFound += $xmasSearch + $samxSearch;

      $xmasSearch = substr_count($str2, "XMAS");
      $samxSearch = substr_count($str2, "SAMX");
      echo "---UpRight. Xmas : $xmasSearch, Samx : $samxSearch";
      $xmasFound += $xmasSearch+$samxSearch;
       */

//
//
//      if (str_contains($str1, "SAMX"))
//        {$xmasFound++;}
//      if (str_contains($str1, "XMAS"))
//      {
//        $xmasFound++;
//      }
//
//      if (str_contains($str2, "XMAS"))
//      {
//        $xmasFound++;
//      }
//
//      if (str_contains($str2, "SAMX"))
//      {$xmasFound++;}
    }
  }
}


// vertical check
$currentString = "";
foreach ($columnArr as $column => $value) {
  $currentString = implode("", $value);
//  echo "<br>Column $column. String : $currentString";
/** Part 1
  $xmasSearch = substr_count($currentString, "XMAS");
  $samxSearch = substr_count($currentString, "SAMX");
  $xmasFound += $xmasSearch+$samxSearch;
*/
}

echo "<hr>XMAS found " . $xmasFound;