<?php
require_once 'autoload.php';

$Util->loginRequired();

if ($Util->getRole() != 'teacher') {
    die('Not found!');
}

$data = [];
$sql = "SELECT *, tbl_quizzes.fld_title AS fld_quiz FROM tbl_section_quizzes
                        LEFT JOIN tbl_quizzes ON tbl_quizzes.fld_quiz_id = tbl_section_quizzes.fld_quiz_id
                        LEFT JOIN tbl_section_students ON tbl_section_students.fld_section_id = tbl_section_quizzes.fld_section_id
                        LEFT JOIN tbl_users ON tbl_users.fld_user_id = tbl_section_students.fld_user_id
                        LEFT JOIN tbl_profiles ON tbl_profiles.fld_profile_id = tbl_users.fld_profile_id
                        LEFT JOIN tbl_section_quiz_summaries ON tbl_section_quiz_summaries.fld_section_quiz_id = tbl_section_quizzes.fld_section_quiz_id";

if ($Util->getRole() == 'student') {
    $sql .= " WHERE tbl_section_students.fld_user_id = ?";
    $data[] = $_SESSION['fld_user_id'];

} else if ($Util->getRole() == 'teacher') {
    $sql .= " LEFT JOIN tbl_section_teachers ON tbl_section_teachers.fld_section_id = tbl_section_quizzes.fld_section_id
            WHERE tbl_section_teachers.fld_user_id = ?";
    $data[] = $_SESSION['fld_user_id'];
}
$orderBy = " ORDER BY tbl_section_quizzes.fld_start_on";

$summaries = $DB->fetchAll($sql . $orderBy, $data);

$sql .= " GROUP BY tbl_section_quizzes.fld_section_quiz_id";
$titles = $DB->fetchAll($sql . $orderBy, $data);

$students = $DB->fetchAll('SELECT *, tbl_section_students.fld_user_id FROM tbl_section_students
                LEFT JOIN tbl_users ON tbl_users.fld_user_id = tbl_section_students.fld_user_id
                LEFT JOIN tbl_profiles ON tbl_profiles.fld_profile_id = tbl_users.fld_profile_id
                LEFT JOIN tbl_section_teachers ON tbl_section_teachers.fld_section_id = tbl_section_students.fld_section_id
                WHERE tbl_section_teachers.fld_user_id = ?', [$_SESSION['fld_user_id']]);

$records = array_map(function($student) use ($DB) {
    $student['fld_quiz_summaries'] = $DB->fetchAll('SELECT * FROM tbl_section_quizzes
                                LEFT JOIN tbl_quizzes ON tbl_quizzes.fld_quiz_id = tbl_section_quizzes.fld_quiz_id
                                LEFT JOIN tbl_section_quiz_summaries ON tbl_section_quiz_summaries.fld_section_quiz_id = tbl_section_quizzes.fld_section_quiz_id
                                LEFT JOIN tbl_section_students ON tbl_section_students.fld_section_id = tbl_section_quizzes.fld_section_id
                                WHERE tbl_section_students.fld_user_id = ?', [$student['fld_user_id']]);
    return $student;
}, $students);

require_once 'header.php' ?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Reports</h1>
                    <ul class="breadcrumb">
                        <!-- <li><a href="<?= $config['base'] ?>/reports.php">Reports</a></li> -->
                        <li class="active">Reports</li>
                        <li><a href="<?= $config['base'] ?>/analytics.php">Analytics</a></li>
                    </ul>
                    <div id="toolbar">
                        <button type="button" class="btn btn-primary" data-toggle="print" data-target="#summary-table"><i class="fa fa-print fa-fw"></i></button>
                    </div>
                    <table data-toggle="table" data-pagination="true" id="summary-table" data-search="true" data-toolbar="#toolbar">
                        <thead>
                            <tr>
                                <?php if ($Util->getRole() != 'student'): ?>
                                    <th>Student</th>
                                <?php endif ?>
                                <?php $i = 1;
                                $quizzes = []; ?>
                                <?php foreach ($titles as $title): ?>
                                    <?php $quizzes[] = $title['fld_section_id'] ?>
                                    <th data-toggle="tooltip" title="<?= $title['fld_quiz'] ?>"><a href="<?= $config['base'] ?>/section_quiz_teacher.php?id=<?= $title['fld_section_quiz_id'] ?>">Q<?= $i ?></a></th>
                                    <?php $i++ ?>
                                <?php endforeach ?>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $student): ?>
                                <tr>
                                    <td><?= ucwords($student['fld_first_name'] .' '. substr($student['fld_middle_name'], 0, 1) .'. '. $student['fld_last_name']) ?></td>
                                    <?php $total = [] ?>
                                    <?php foreach ($student['fld_quiz_summaries'] as $summary): ?>
                                        <td><a href="<?= $config['base'] ?>/section_quiz_stats.php?id=<?= $summary['fld_section_quiz_id'] ?>&student_id=<?= $student['fld_student_id'] ?>"><?= $summary['fld_score'] ? $summary['fld_score'] .'/'. $summary['fld_total_questions']: 'N/A' ?></a></td>
                                        <?php $total[] = $summary['fld_score'] ? (100 / $summary['fld_total_questions']) * $summary['fld_score'] : 'N/A' ?>
                                    <?php endforeach ?>
                                    <?php if (in_array('N/A', $total)): ?>
                                        <td><?= 'N/A' ?></td>
                                    <?php else: ?>
                                        <td><?= array_sum($total) / count($total) ?>%</td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<?php require_once 'footer.php' ?>
