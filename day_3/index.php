<?php

$realInput = file_get_contents('real_input.txt', true);
$sample = 'xmul(2,4)%&mul[3,7]!@^do_not_mul(5,5)+mul(32,64]then(mul(11,8)mul(8,5))';

$sampleStep2 = "xmul(2,4)&mul[3,7]!^don't()_mul(5,5)+mul(32,64](mul(11,8)undo()?mul(8,5))";

$split = str_split($realInput);

$valid = false;
$current = "";
$numberFound = false;
$commaFound = false;
$number1 = null;
$number2 = null;
$total = 0;
$doFound = 'true';
$dontFound = 'false';
$currentDo = "";
foreach ($split as $value) {
  echo "<br>".$value;
  echo "<br>DoFound = $doFound, DontFound = $dontFound";

  if ($doFound == 'true'){
    if ($value == "m")
    {
      $current = $value;
    }
    elseif ($current == 'm' && $value == 'u')
    {
      $current .= $value;
    }
    elseif ($current == 'mu' && $value == 'l')
    {
      $current .= $value;
    }
    elseif ($current == 'mul' && $value == '(')
    {
      $current .= $value;
      $valid = true;
    }
    elseif ($current == 'mul(' && is_numeric($value))
    {
      if ($commaFound)
      {
        $number2 .= $value;
        echo "---------Number 2 : $number2";
      }
      else
      {
        $number1 .= $value;
        echo "---------Number 1 : $number1";

      }
    }
    elseif ($current == 'mul(' && $value == ",")
    {
      $commaFound = true;
    }
    elseif ($current == 'mul(' && $value == ")")
    {
      $total += $number1 * $number2;
      echo "<br>Nr 1 : $number1 x Nr 2 : $number2. Total : $total";
      $current = "";
      $commaFound = false;
      $number1 = "";
      $number2 = "";
    }
    else
    {
      $current = "";
      $commaFound = false;
      $number1 = "";
      $number2 = "";
    }
  }

  if (in_array($value, ['d','o','n', 't',"'", "(", ")"]))
  {
    if ($value == 'd')
    {
      $currentDo = $value;
    }
    else
    {
      $currentDo .= $value;
    }
  }

  if ($currentDo == 'do()')
  {
    $doFound = 'true';
    $dontFound = 'false';
    $currentDo = "";
  }
  elseif ($currentDo == "don't()")
  {
    $doFound = 'false';
    $dontFound = 'true';
    $currentDo = "";
  }
  echo "---- Current : $currentDo";
}

echo "<hr>Total : $total";