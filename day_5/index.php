<?php

$realInput = file_get_contents('real_input.txt', true);


$sample = "47|53
97|13
97|61
97|47
75|29
61|13
75|53
29|13
97|29
53|29
61|53
97|53
61|29
47|13
75|47
97|75
47|61
75|61
47|29
75|13
53|13

75,47,61,53,29
97,61,53,29,13
75,29,13
75,97,47,61,53
61,13,29
97,13,75,29,47";

$sections = explode("

", $realInput);

$pageOrderingRules = explode("\n", $sections[0]);
$pageNumbers = explode("\n", $sections[1]);

$oldPageOrderingRules = $pageOrderingRules;
//var_dump($oldPageOrderingRules);
$pageOrderingRules = [];
foreach ($oldPageOrderingRules as $key => $value) {
  $valueArr = explode("|", $value);
  $pageOrderingRules[$key][0] = $valueArr[0];
  $pageOrderingRules[$key][1] = $valueArr[1];
}

$finalNumbers = [];
foreach ($pageNumbers as $key => $value) {
  echo "<br>Numbers : $value";
  $numbers = explode(",", $value);
  $correct = 'not checked';
  $breakingCount = 0;
  foreach ($numbers as $index => $number) {
//    echo "<br> Number checked : $number";
    $breakingRules = [];
    foreach ($pageOrderingRules as $key2 => $rules) {
      if ($number == $rules[0] && in_array($rules[1], $numbers))
      {
//        echo "<br>---Rule checked : $rules[0], $rules[1]";

        $index2 = array_search($rules[1], $numbers);
        if ($index2 !== false && $index < $index2)
        {
          $correct = 'true';
        }
        else
        {
          $correct = 'breaking';
          $breakingCount++;
          $breakingNumber[$value]['rules'][] = $rules;
        }
      }
//      echo "<br>----Check with rule $rules[0], $rules[1]. Result : $correct";
    }

  }

  if ($breakingCount == 0) {
    $finalNumbers[] = $value;
  }

}
//var_dump($finalNumbers);

$total = 0;
foreach ($finalNumbers as $key => $value) {
  $valArr = explode(",", $value);
  $midKey = (int)(count($valArr)/2);
  echo "<br>Mid key $key : $valArr[$midKey]";
    $total += $valArr[$midKey];
}

var_dump($total);
echo "<hr>";

$totalBreakingMid = 0;
foreach ($breakingNumber as $key => $value)
{
  $currentNumber = explode(",", $key);
  $newNumber = $currentNumber;

  $newNumber = [];
  foreach ($currentNumber as $numberIndex => $numberValue)
  {
    $newNumber["".$numberValue]['left'] = 0;
    $newNumber["".$numberValue]['right'] = 0;
  }

  $possibilityOfNewNumber = [];
  echo "<br>Breaking Number : $key";
  foreach ($pageOrderingRules as $key2 => $value2)
  {

//    $array = explode("|", $value2);
    if (in_array($value2[0], $currentNumber) && in_array($value2[1], $currentNumber))
    {
      $newNumber["".$value2[1]]['left']++;
      $newNumber["".$value2[0]]['right']++;
    }
//    echo "<br>---Rules $key2 : [$array[0], $array[1]]";
//    $index = array_search($array[0], $currentNumber);
//    echo "<br>--- Location of $array[0] is $index";
//    $index2 = array_search($array[1], $currentNumber);
//    echo "<br>--- Location of $array[1] is $index2";
//
//    if ($index2 - 1 >= 0)
//    {
//      $newNumber[$index] = $newNumber[$index2-1];
//      $newNumber[$index2-1] = $array[0];
//    }
//    echo "<br>---Moving $value2[0] to $index2. $value2[1] to $index";
//    echo "<br>---- New number order -------------------". implode(",", $newNumber);

  }


  $numberCount = count($currentNumber);

  echo "<br>--------- BROKEN RULES : ";

  foreach ($value['rules'] as $brokenKey => $brokenRule)
  {
    echo "<br>" . implode(",", $brokenRule);
  }

  $freshNumber = $currentNumber;
  foreach ($newNumber as $number => $numberVal)
  {
    echo "<br>Number $number. Left : {$numberVal['left']} Right : {$numberVal['right']}";
    $possibleCordinate = [];

    $min = $numberVal['left'];
    $max = $numberCount-1-$numberVal['right'];
    if ($min == $max)
    {
      $freshNumber[$min] = $number;
    }

    echo " ---- Possible coordinate. Min : " .$min  . "Max : " . $max;
  }

  echo "<br>---- Fresh number : " . implode(",", $freshNumber);
  $midKey = (int)(count($freshNumber) / 2);
  echo "<br>---Breaking mid number : " . $freshNumber[$midKey];
  $totalBreakingMid += $freshNumber[$midKey];
}
//
//foreach ($newNumber as $key => $value) {
echo "<br>Total breaking number mid : $totalBreakingMid";
//}