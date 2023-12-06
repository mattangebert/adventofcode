<?php
/**
 * Copyright © Flagbit GmbH & Co. KG All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

$input = file('./input.txt');
trebuchet($input);

function trebuchet(array $inputs):int {
    $result = 0;

    $alphabeticNumbers = [
        'zero' => 0,
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'five' => 5,
        'six' => 6,
        'seven' => 7,
        'eight' => 8,
        'nine' => 9
    ];


    foreach ($inputs as $input) {
        $matches = [];

        // part 1
        //$regex = '/[1-9]/';

        // part 2
        $regex = '/(?=([1-9]|one|two|three|four|five|six|seven|eight|nine))/';

        preg_match_all($regex, $input, $matches);


        // part 1
        $first = reset($matches[0]);
        $last = end($matches[0]);


        $first = reset($matches[1]);
        $last = end($matches[1]);

        $first = strlen($first) > 1 ? $alphabeticNumbers[$first] : $first;
        $last = strlen($last) > 1 ? $alphabeticNumbers[$last] : $last;

        //var_dump($matches);

        $number = (int) ($first . $last);

        $result += $number;

        echo '<pre>';
        echo $input;
        echo '<br>';
        echo 'first: ' . $first;
        echo '<br>';
        echo 'last: ' . $last;
        echo '<br>';
        echo $number;
        echo '<br>';
        echo 'current: ' . $result;
        echo '</pre>';
    }


    echo 'result: ' . $result;

    return $result;
}