<?php
/**
 * Copyright © Flagbit GmbH & Co. KG All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

$inputs = file('./input.txt');
$testInput = [
    '467..114..',
    '...*......',
    '..35..633.',
    '......#...',
    '617*......',
    '.....+.58.',
    '..592.....',
    '......755.',
    '...$.*....',
    '.664.598..'
];

task($inputs);

function task(array $inputs) {
    $length = count($inputs);
    $lineLength = strlen($inputs[0]);
    $foundCords = [];

    $sum = 0;
    $gearSum = 0;

    foreach ($inputs as $key => $input) {
        $row = $input;
        $rowBeforeKey = $key - 1;
        $rowAfterKey = $key + 1;

        $rowBefore = $rowBeforeKey >= 0 ? $inputs[$rowBeforeKey] : null;
        $rowAfter = $rowAfterKey < $length ? $inputs[$rowAfterKey] : null;

        // find symbols
        $regex = '/([^\d.\s])/';
        $matches = [];

        preg_match_all($regex, $input, $matches, PREG_OFFSET_CAPTURE);

        foreach ($matches[0] as $match) {
            $symbol = $match[0];

            $isGear = false;
            $parts = 0;
            $gearValue = 0;
            if ($symbol === '*') {
                $isGear = true;
            }

            print 'symbol ' . $symbol . '<br>';

            $position = $match[1];

            // checking on pos -1, pos, pos + 1 for each row
            for ($i = $position - 1; $i <= ($position + 1); $i++) {
                if ($i < 0 || $i >= $lineLength) {
                    continue;
                }

                // row before
                if ($rowBefore !== null) {
                    $number = checkRowNumber($foundCords, $rowBefore, $rowBeforeKey, $i, $lineLength);

                    if (is_numeric($number)) {
                        if ($isGear) {
                            $parts ++;
                            checkGear($gearSum, $gearValue, $parts, (int) $number);
                        }

                        print 'before number: ' . $number . '<br>';
                        $sum += (int) $number;
                        print 'new number: ' . $sum . '<br><br>';
                    }

                }

                // current row
                if ($i !== $position) {
                    $number = checkRowNumber($foundCords, $row, $key, $i, $lineLength);

                    if (is_numeric($number)) {
                        if ($isGear) {
                            $parts ++;
                            checkGear($gearSum, $gearValue, $parts, (int) $number);
                        }

                        print 'row number: ' . $number . '<br>';
                        $sum += (int) $number;
                        print 'new number: ' . $sum . '<br><br>';
                    }

                }

                // next row
                if ($rowAfter !== null) {
                    $number = checkRowNumber($foundCords, $rowAfter, $rowAfterKey, $i, $lineLength);

                    if (is_numeric($number)) {
                        if ($isGear) {
                            $parts ++;
                            checkGear($gearSum, $gearValue, $parts, (int) $number);
                        }

                        print 'after number: ' . $number . '<br>';
                        $sum += (int) $number;
                        print 'new number: ' . $sum . '<br><br>';
                    }
                }
            }

            print '*************************************<br>';
        }
    }

    echo 'task 1: ' . $sum . '<br>';
    echo 'task 2: ' . $gearSum;

    return $sum;
}

function checkGear(int &$gearSum, &$gearValue, int $part, int $number)
{
    if ($part === 1) {
        $gearValue = $number;
    } else if ($part === 2) {
        $value = $gearValue * $number;
        $gearSum += $value;
    }
}

function checkRowNumber(array &$foundCords, string $rowToCheck, int $rowKey, int $fieldIndex, int $length) {

    $char = $rowToCheck[$fieldIndex];
    $number = '';

    if (is_numeric($char) && !isset($foundCords[$rowKey][$fieldIndex])) {
        $foundCords[$rowKey][$fieldIndex] = true;
        $number = '' . $char;

        $j = $fieldIndex - 1;
        while ($j >= 0 && is_numeric($rowToCheck[$j])) {
            $foundCords[$rowKey][$j] = true;
            $number = $rowToCheck[$j] . '' . $number;

            $j--;
        }

        $k = $fieldIndex + 1;

        while ($k <= $length && is_numeric($rowToCheck[$k])) {
            $foundCords[$rowKey][$k] = true;
            $number .= $rowToCheck[$k];

            $k++;
        }
    }

    return $number;
}