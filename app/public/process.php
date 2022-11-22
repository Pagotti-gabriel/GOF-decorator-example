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

$style = getStyle($selectedFilters);

$nonSelectedFilters = array_values(array_diff(FILTERS, $selectedFilters));
$nonSelectedFilters = array_values($nonSelectedFilters);

echo json_encode([
    'style' => $style,
    'selectedFilters' => $selectedFilters,
    'nonSelectedFilters' => $nonSelectedFilters,
]);

// TODO - Utilize decorator here
function getStyle($selectedFilters = [])
{
    $filter = 'filter: ';
    $style = '';

    if(in_array('blur', $selectedFilters)){
        $filter .= 'blur(5px) ';
    }
    if(in_array('rotate', $selectedFilters)){
        $style .= 'transform: rotate(180deg);';
    }
    if(in_array('grayscale', $selectedFilters)){
        $filter .= 'grayscale(100%) ';
    }
    if(in_array('invert', $selectedFilters)){
        $filter .= 'invert(100%) ';
    }
    if(in_array('sepia', $selectedFilters)){
        $filter .= 'sepia(100%) ';
    }

    $filter = trim($filter).';';

    if ($filter === 'filter: ;') {
        $filter = '';
    }

    return $style.$filter;
}