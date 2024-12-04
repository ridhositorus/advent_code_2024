<?php

$realInput = file_get_contents('real_input.txt', true);

$sample = "7 6 4 2 1
1 2 7 8 9
9 7 6 2 1
1 3 2 4 5
8 6 4 4 1
1 3 6 7 9
7 5 8 9 9
64 65 70 73 75 79
61 61 63 65 68 70 73 71
67 71 72 73 76 75 72
32 30 29 26 20";

function checkRow($row, $level = 0)
{
  if ($level > 1)
  {
    return "Unsafe";
  }
//  echo "<hr>";

  $columns = explode(" ", $row);
//  echo "Item $row";
  $summary[$row] = ['up' => [], 'down' => [], 'invalid' => [], 'result' => "Safe", 'trend' => "", 'unsafeKey' => null];
  $safeExist = false;
  foreach ($columns as $key => $column)
  {
    $nextIndex = $key + 1;
    $result = null;
    if ($nextIndex < count($columns))
    {
      $result = $column - $columns[$nextIndex];
      echo "<br>$column - $columns[$nextIndex] : $result";
    }

    if ($result === 0 || abs($result) > 3)
    {
      $summary[$row]['unsafeKey'] = $key;
      $summary[$row]['invalid'][] = $key;
      $summary[$row]['invalid'][] = $nextIndex;
    }
    elseif ($result > 0)
    {
      $summary[$row]['down'][] = $key;
    }
    elseif ($result < 0)
    {
      $summary[$row]['up'][] = $key;
    }
  }

  $countUp = count($summary[$row]['up']);
  $countDown = count($summary[$row]['down']);
  $trend = $countUp > $countDown ? "up" : "down";
  $summary[$row]['trend'] = $trend;

  $unsafeKey = $summary[$row]['unsafeKey'];
  if ($unsafeKey === null && ($countUp == 1 || $countDown == 1))
  {
    if ($summary[$row]['trend'] === 'up')
    {
      $unsafeKey = end($summary[$row]['down']);
    }
    elseif ($summary[$row]['trend'] === 'down')
    {
      $unsafeKey = end($summary[$row]['up']);
    }
  }
  elseif (($countUp > 1 && $countDown > 1) || count($summary[$row]['invalid']) > 2)
  {
//    echo "Unsafe count : ";
//    print_r($summary[$row]['invalid']);
    return "Unsafe";
  }

  $summary[$row]['unsafeKey'] = $unsafeKey;
  echo "<br>Trend : $trend";

  if ($unsafeKey === null)
  {
    $summary[$row]['result'] = "Safe";
  }

  if (count($summary[$row]['invalid']) > 0)
  {
    $summary[$row]['result'] = "Unsafe";
//    print_r($summary[$row]);
    echo "<br>---- Level $level . Arr : " . implode(",", $columns) . " Removed key : $unsafeKey";

    foreach ($summary[$row]['invalid'] as $i => $val)
    {
      $newArr = [];

      foreach ($columns as $key => $value)
      {
        if ($key != $val) $newArr[] = $value;
      }
      $res = checkRow(implode(" ", $newArr), $level + 1);
      if ($res == 'Safe') return "Safe";
    }
    return "Unsafe";

  }

  return $unsafeKey === null ? 'Safe' : $summary[$row]['result'];

}
function problemDampener($items)
{
  $rows = explode("\n", $items);
  $countSafe = 0;
  foreach ($rows as $row)
  {
    echo "<hr>$row";
    $status = checkRow($row);
    echo "<br>$row : $status";

    if ($status == 'Safe')
    {
      $countSafe++;
    }
  }
  echo "<br>Total safe $countSafe";
}

problemDampener($sample);

// 666 incorrect
// 614 incorrect

// 598 too low
// 586 too low
// 825 too high
// 635 not correct
// 584 not correct
// 587 not correct

