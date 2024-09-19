<?php

require __DIR__ . '/toothColor.php';

$letters = range('A', 'T');
$numbers = range(1, 32);
$all = array_merge($letters, $numbers);

// Color all the teeth
// toothColor(__DIR__ . '/storage/original/image.svg', ...$all);

// Color just the letters
// toothColor(__DIR__ . '/storage/original/image.svg', ...$letters);

// Color just the numbers
// toothColor(__DIR__ . '/storage/original/image.svg', ...$numbers);

// Color custom teeth
toothColor(__DIR__ . '/storage/original/image.svg', 'O', 'A', 1, 12, 'T');
