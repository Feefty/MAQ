<?php
require_once '../autoload.php';

$questions = $DB->fetchAll('SELECT *, COUNT(*) as fld_total_count FROM tbl_quiz_questions GROUP BY fld_category');
$labels = array_map(function($question) use($config) {
    return $config['question']['categories'][$question['fld_category']];
}, $questions);
$questionTypes = array_map(function($question) {
    return $question['fld_total_count'];
}, $questions);
$backgroundColors = array_map(function($question) {
    return '#'.substr(md5($question['fld_category']), 0, 6);
}, $questions);

$data = [
    'labels' => $labels,
    'datasets' => [
        [
            'data' => $questionTypes,
            'backgroundColor' => $backgroundColors
        ]
    ]
];

die(json_encode($data));
?>
