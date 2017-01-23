<?php
require_once '../autoload.php';

$results = $DB->fetchAll('SELECT *, COUNT(tbl_quizzes.fld_subject_id) as fld_total_subject_count FROM tbl_quizzes
                            LEFT JOIN tbl_subjects ON tbl_subjects.fld_subject_id = tbl_quizzes.fld_subject_id
                            GROUP BY tbl_subjects.fld_subject_id');
$labels = array_map(function($result) {
    return $result['fld_name'];
}, $results);
$datasets = array_map(function($result) {
    return $result['fld_total_subject_count'];
}, $results);
$backgroundColors = array_map(function($result) {
    return '#'.substr(md5($result['fld_name']), 0, 6);
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
