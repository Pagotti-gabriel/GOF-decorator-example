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
$nonSelectedFilters = array_diff(FILTERS, $selectedFilters);

echo json_encode([
    'filters' => FILTERS,
    'selectedFilters' => $selectedFilters,
    'nonSelectedFilters' => $nonSelectedFilters,
]);

