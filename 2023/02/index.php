<?php
/**
 * Copyright © Flagbit GmbH & Co. KG All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

$inputs = file('./input.txt');
cubeConundrum($inputs);

function cubeConundrum(array $inputs) {
    $sum = 0;
    $sum2 = 0;

    foreach ($inputs as $key => $input) {
        $id = $key + 1;
        $matches = [];
        $matchesRed = [];
        $matchesGreen = [];
        $matchesBlue = [];

        // max 12 red, 13, green, 14 blue
        $regex = '/([1][3-9]|\d{3,}) red|([1][4-9]|\d{3,}) green|([1][5-9]|\d{3,}) blue|([2-9][0-9]|\d{3,}) /';

        $regexRed = '/(\d+) red/';
        $regexGreen = '/(\d+) green/';
        $regexBlue = '/(\d+) blue/';

        preg_match_all($regex, $input, $matches);
        preg_match_all($regexRed, $input, $matchesRed);
        preg_match_all($regexGreen, $input, $matchesGreen);
        preg_match_all($regexBlue, $input, $matchesBlue);

        $maxRed = max($matchesRed[1]);
        $maxGreen = max($matchesGreen[1]);
        $maxBlue = max($matchesBlue[1]);

        $max = $maxRed * $maxGreen * $maxBlue;
        $sum2 += $max;

        echo $maxRed;
        echo '<br>';

        if (count($matches[0]) <= 0) {
            $sum += (int) $id;
        }


    }

    echo 'ergebniss: ' . $sum . '<br>';
    echo 'ergbeniss 2: ' . $sum2;
}