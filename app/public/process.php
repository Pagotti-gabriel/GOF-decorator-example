<?php

header('Content-Type: application/json; charset=utf-8');

const FILTERS = [
    'blur',
    'rotate',
    'grayscale',
    'invert',
    'sepia',
];

$selectedFilters = $_GET['filters'] ?? [];

$nonSelectedFilters = array_values(array_diff(FILTERS, $selectedFilters));
$nonSelectedFilters = array_values($nonSelectedFilters);

echo json_encode([
    'selectedFilters' => $selectedFilters,
    'nonSelectedFilters' => $nonSelectedFilters,
]);

