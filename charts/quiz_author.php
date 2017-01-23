<?php
require_once '../autoload.php';

$results = $DB->fetchAll('SELECT *, COUNT(tbl_quizzes.fld_quiz_id) as fld_total_quiz_count FROM tbl_quizzes
                        LEFT JOIN tbl_users ON tbl_users.fld_user_id = tbl_quizzes.fld_user_id
                        LEFT JOIN tbl_profiles ON tbl_profiles.fld_profile_id = tbl_users.fld_profile_id
                        WHERE tbl_users.fld_profile_id > 0
                        GROUP BY tbl_users.fld_user_id');
$labels = array_map(function($result) {
    return ucwords($result['fld_first_name'] .' '. substr($result['fld_middle_name'], 0, 1) .'. '. $result['fld_last_name']);
}, $results);
$datasets = array_map(function($result) {
    return $result['fld_total_quiz_count'];
}, $results);
$backgroundColors = array_map(function($result) {
    return '#'.substr(md5($result['fld_first_name'] .' '. substr($result['fld_middle_name'], 0, 1) .'. '. $result['fld_last_name']), 0, 6);
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
