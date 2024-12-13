<?php

$realInput = file_get_contents('real_input.txt', true);

$sample = "....#.....
.........#
..........
..#.......
.......#..
..........
.#..^.....
........#.
#.........
......#...";

$sampleArr = explode("\n", $sample);
$allPosition = [];
$startingPosition = "";
foreach ($sampleArr as $rowKey => $item)
{
  $itemArr = str_split($item);
  foreach ($itemArr as $itemKey => $itemValue)
  {
    $allPosition[$rowKey][$itemKey] = $itemValue;
    if ($itemValue == "^")
    {
      $startingPosition = $rowKey . "," . $itemKey;
    }
  }
}

$startingDestination = "^";
echo "<hr>";
echo "<br>Starting position : ".
printPosition($allPosition);
var_dump($startingPosition);

move($allPosition, $startingPosition, $startingDestination);
echo "<hr>";
echo "<br>Final position : ".
$xCount = 0;
foreach ($allPosition as $rowKey => $item)
{
  foreach ($item as $itemKey => $itemValue)
  {
    if ($itemValue == "X") $xCount++;
  }
}
echo "<br>Total X : " . $xCount+1;

function printPosition($allPosition)
{
  foreach ($allPosition as $item)
  {
    echo "<br>" . implode("   ", $item);
  }
}

function move(&$fullPosition, $currentPosition, $destination = null)
{
  if ($destination === "^")
  {
    return moveUp($fullPosition, $currentPosition, $destination);
  }
  elseif ($destination === "v")
  {
    return moveDown($fullPosition, $currentPosition, $destination);
  }
  elseif ($destination === ">")
  {
    return moveRight($fullPosition, $currentPosition, $destination);
  }
  elseif ($destination === "<")
  {
    return moveLeft($fullPosition, $currentPosition, $destination);
  }
}

function moveUp(&$fullPostion, &$currentPosition, &$destination)
{
  $position = explode(",", $currentPosition);
  if (!is_numeric($position[0])) echo "<br>CurPost : $currentPosition Position 1 is '$position[0]'";
  $movingPosition = $position[0] - 1 . "," . $position[1];
  $movingPosArr = explode(",", $movingPosition);
  if ($position == 0) return $fullPostion;
  echo "<br>Current Position : $currentPosition Moving to $movingPosition . Destination value = " . $fullPostion[$position[0] - 1][$position[1]];
  for($i = $movingPosArr[0]; $i >= 0; $i--)
  {
    echo "<hr>";
    if ($fullPostion[$i][$position[1]] !== "#")
    {
      $fullPostion[$i+1][$position[1]] = "|";
      $fullPostion[$i][$position[1]] = "^";
      $currentPosition = $i . "," . $position[1];
      printPosition($fullPostion);
    }
    else
    {
      echo "<br>Cant no longer move up";

      $fullPostion[$i+1][$position[1]] = "+";
      printPosition($fullPostion);
      $newDestination = "v";
      return moveRight($fullPostion, $currentPosition, $newDestination);
      break;
    }
  }

//  if ($position[0] > 0 && $fullPostion[$position[0] - 1][$position[1]] !== "#")
//  {
//    $currentPosition = $movingPosition;
//    $fullPostion[$position[0]][$position[1]] = 'X';
//    $fullPostion[$position[0] - 1][$position[1]] = '^';
//    printPosition($fullPostion);
//
//     return moveUp($fullPostion, $currentPosition, $destination);
//  }
//  else
//  {
//    echo "<br> Can't continue up. Moving right . Current position $position[0], $position[1]";
//    $fullPostion[$position[0]][$position[1]] = '>';
//    printPosition($fullPostion);
//     return move($fullPostion, $currentPosition, ">");
//  }
}

function moveDown(&$fullPostion, &$currentPosition, &$destination)
{
  echo "<br>Moving Down";
  $position = explode(",", $currentPosition);
  $movingPosition = $position[0] + 1 . "," . $position[1];
  $movingPosArr = explode(",", $movingPosition);
  if ($position[0] == count($fullPostion) -1) return $fullPostion;
  for($i = $position[0]+1; $i < count($fullPostion); $i++)
  {
    echo "<hr>";
    if ($fullPostion[$i][$position[1]] !== "#")
    {
      $fullPostion[$i-1][$position[1]] = "|";
      $fullPostion[$i][$position[1]] = "v";
      $currentPosition = $i . "," . $position[1];
      printPosition($fullPostion);
    }
    else
    {
      echo "<br>Cant no longer move down";

      $fullPostion[$i-1][$position[1]] = "+";
      printPosition($fullPostion);
      $newDestination = "v";
//      return moveLeft($fullPostion, $currentPosition, $newDestination);
      break;
    }
  }


//  if ($movingPosArr[0] < count($fullPostion) && $fullPostion[$movingPosArr[0]][$movingPosArr[1]] !== "#")
//  {
//    $currentPosition = $movingPosition;
//    $fullPostion[$position[0]][$position[1]] = 'X';
//    $fullPostion[$movingPosArr[0]][$movingPosArr[1]] = 'v';
//    printPosition($fullPostion);
//    return moveDown($fullPostion, $currentPosition, $destination);
//  }
//  else
//  {
//    $fullPostion[$position[0]][$position[1]] = '<';
//    printPosition($fullPostion);
//    return move($fullPostion, $currentPosition, "<");
//  }
}

function moveRight(&$fullPostion, &$currentPosition, &$destination)
{
  $position = explode(",", $currentPosition);
  $movingPosition = $position[0] . "," . $position[1]+1;
  $movingPosArr = explode(",", $movingPosition);
//  var_dump($movingPosArr);
  if ($position[1] > count($fullPostion[0])) return $fullPostion;

  for($i = $position[1]+1; $i < count($fullPostion[0]); $i++)
  {
    echo "<hr>";
    if ($fullPostion[$position[0]][$i] !== "#")
    {
      if (in_array($fullPostion[$position[0]][$i-1], ["-", "|"]))
      {
        $fullPostion[$position[0]][$i-1] = "+";
      }
      else
      {
        $fullPostion[$position[0]][$i-1] = "-";
      }
      $fullPostion[$position[0]][$i] = ">";
      $currentPosition = $position[0] . "," . $i;
      printPosition($fullPostion);
    }
    else
    {
      echo "<br>Cant no longer move right";

      $fullPostion[$position[0]][$i-1] = "+";
      printPosition($fullPostion);
      $newDestination = "v";
//      return moveDown($fullPostion, $currentPosition, $newDestination);
//      break;
    }
  }
}

function moveLeft(&$fullPostion, &$currentPosition, &$destination)
{
  $position = explode(",", $currentPosition);
  $movingPosition = $position[0] . "," . $position[1] - 1;
  $movingPosArr = explode(",", $movingPosition);
  echo "<br>Move to $movingPosition";
  if ($movingPosArr[1] < 0) return $fullPostion;
  for($i = $position[1]-1; $i >= 0; $i--)
  {
    echo "<hr>";
    if ($fullPostion[$position[0]][$i] !== "#")
    {
      if (in_array($fullPostion[$position[0]][$i+1], ["-", "|"]))
      {
        $fullPostion[$position[0]][$i+1] = "+";
      }
      else
      {
        $fullPostion[$position[0]][$i+1] = "-";
      }

      $fullPostion[$position[0]][$i] = "<";
      $currentPosition = $position[0] . "," . $i;
//      printPosition($fullPostion);
    }
    else
    {
      echo "<br>Cant no longer move right";

      $fullPostion[$position[0]][$i+1] = "+";
//      printPosition($fullPostion);
      $newDestination = "^";
      return moveUp($fullPostion, $currentPosition, $newDestination);
      break;
    }
  }



//  if ($fullPostion[$movingPosArr[0]][$movingPosArr[1]] !== "#")
//  {
//    $currentPosition = $movingPosition;
//    $fullPostion[$position[0]][$position[1]] = 'X';
//    $fullPostion[$position[0]][$movingPosArr[1]] = '<';
//    printPosition($fullPostion);
//    return moveLeft($fullPostion, $currentPosition, $destination);
//  }
//  else
//  {
//    echo "<br>Can't no longer move left";
//    $fullPostion[$position[0]][$position[1]] = '^';
//    printPosition($fullPostion);
//    return move($fullPostion, $currentPosition, "^");
//  }
}
