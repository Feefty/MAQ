<?php
require_once '../autoload.php';

$results = $DB->fetchAll('SELECT *, COUNT(*) as fld_total_count FROM tbl_profiles GROUP BY fld_gender');
$labels = array_map(function($result) {
    return ucwords($result['fld_gender']);
}, $results);
$datasets = array_map(function($result) {
    return $result['fld_total_count'];
}, $results);
$backgroundColors = array_map(function($result) {
    return '#'.substr(md5($result['fld_gender']), 0, 6);
}, $results);

$data = [
    'labels' => $labels,
    'datasets' => [
        [
            'data' => $datasets,
            'backgroundColor' => $backgroundColors
        ]
    ]
];

die(json_encode($data));
?>
