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
32 30 29 26 20
27 29 32 33 36 37 40 37
80 77 78 80 83 86 87";

function checkRow($row, $skippedKey = null, $trend = null)
{
  $invalidKeys = [];
  $up = $down = 0;
  $columns = $newColumns = explode(" ", $row);

  if ($skippedKey !== null)
  {
    $columns = [];

    foreach ($newColumns as $keyx => $column)
    {
      if ($keyx !== $skippedKey)
      {
        $columns[] = $column;
      }
    }
    print_r($columns);
  }

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
      $invalidKeys[] = $key;
      if ($nextIndex == count($columns) - 1)
      {
        $invalidKeys[] = $nextIndex;
      }
    }
    elseif ($result > 0)
    {
      if ($trend == 'up') {
        $invalidKeys[] = $key;
        if ($nextIndex == count($columns) - 1)
        {
          $invalidKeys[] = $nextIndex;
        }
      }
      $down++;
    }
    elseif ($result < 0)
    {
      if ($trend == 'down') {
        $invalidKeys[] = $key;
        if ($nextIndex == count($columns) - 1)
        {
          $invalidKeys[] = $nextIndex;
        }
      }
      $up++;
    }
  }
  $trend = $trend === null && $up > $down ? "up" : "down";
  return [$invalidKeys, $trend];
}

function problemDampener($items)
{
  $rows = explode("\n", $items);
  $countSafe = 0;
  foreach ($rows as $row)
  {
    echo "<hr>$row";
    [$invalidKeys, $trendOri] = checkRow($row);
    echo "<br>Main loop result. Invalid keys";
    print_r($invalidKeys);
    echo "--- Trend : $trendOri";


    $status = 'Safe';
    if (count($invalidKeys) > 0)
    {
      $status = 'Unsafe';
      foreach ($invalidKeys as $no => $key)
      {
        echo "<br>Loop $no with excluded key $key";
        [$invalidCount, $trend] = checkRow($row, $key, $trendOri);
        echo "<br>Loop $no invalidCount : ". count($invalidCount). " Keys " . implode(",", $invalidKeys);

        if (count($invalidCount) == 0)
        {
          $status = 'Safe';
          break;
        }
      }
    }
//    else
//    {
      echo "<br>Loop checking with trend $trendOri";
      [$invalidCount, $trend] = checkRow($row, null, $trendOri);
      echo "<br>>Loop checking with trend $trendOri invalidCount : ". count($invalidCount);

      if (count($invalidCount) == 0)
      {
        $status = 'Safe';
      }
      else
      {
        $status = 'Unsafe';
        foreach ($invalidCount as $no => $key)
        {
          echo "<br>Loop $no with excluded key $key";
          [$cnt, $trend] = checkRow($row, $key, $trendOri);
          echo "<br>Loop $no invalidCount : ". count($cnt);

          if (count($cnt) == 0)
          {
            $status = 'Safe';
            break;
          }
        }
      }
    // } // removing this resulted 601

    echo "<br>$row : $status";

    if ($status == 'Safe')
    {
      $countSafe++;
    }
  }
  echo "<br>Total safe $countSafe";
}

problemDampener($realInput);
//80 77 78 79 83 86 87

// last unsafe checked 60 56 53 54 52 51 53
// 22 26 25 26 29 33 supposed to be safe by skipping 267


// 666 incorrect
// 614 incorrect

// 598 too low
// 586 too low
// 825 too high
// 635 not correct
// 584 not correct
// 587 not correct
// 600 not correct



// 601 not tried

