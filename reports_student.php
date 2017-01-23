<?php
require_once 'autoload.php';

$Util->loginRequired();

$data = [];
$sql = "SELECT *, tbl_quizzes.fld_title as fld_quiz, tbl_sections.fld_name as fld_section FROM tbl_section_quiz_summaries
        LEFT JOIN tbl_section_quizzes ON tbl_section_quizzes.fld_section_quiz_id = tbl_section_quiz_summaries.fld_section_quiz_id
        LEFT JOIN tbl_sections ON tbl_sections.fld_section_id = tbl_section_quizzes.fld_section_id
        LEFT JOIN tbl_quizzes ON tbl_quizzes.fld_quiz_id = tbl_section_quizzes.fld_quiz_id
        LEFT JOIN tbl_section_students ON tbl_section_students.fld_section_id = tbl_sections.fld_section_id
        LEFT JOIN tbl_users ON tbl_users.fld_user_id = tbl_section_students.fld_user_id
        LEFT JOIN tbl_profiles ON tbl_profiles.fld_profile_id = tbl_users.fld_profile_id";

if ($Util->getRole() == 'student') {
    $sql .= " WHERE tbl_section_students.fld_user_id = ?";
    $data[] = $_SESSION['fld_user_id'];

} else if ($Util->getRole() == 'teacher') {
    $sql .= " LEFT JOIN tbl_section_teachers ON tbl_section_teachers.fld_section_id = tbl_sections.fld_section_id
            WHERE tbl_section_teachers.fld_user_id = ?";
    $data[] = $_SESSION['fld_user_id'];
}
$sql .= " ORDER BY tbl_section_quizzes.fld_section_quiz_id";

$summaries = $DB->fetchAll($sql, $data);

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
                                    <th>Section</th>
                                <?php endif ?>
                                <th>Quiz</th>
                                <th>Score</th>
                                <th>Date Finished</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($summaries as $summary): ?>
                                <tr>
                                    <?php if ($Util->getRole() != 'student'): ?>
                                        <td><?= ucwords($summary['fld_first_name'] .' '. substr($summary['fld_middle_name'], 0, 1) .'. '. $summary['fld_last_name']) ?></td>
                                        <td><?= $summary['fld_section'] ?></td>
                                        <td><a href="<?= $config['base'] ?>/section_quiz_stats.php?id=<?= $summary['fld_section_quiz_id'] ?>&student_id=<?= $summary['fld_student_id'] ?>"><?= $summary['fld_quiz'] ?></a></td>
                                    <?php else: ?>
                                        <td><a href="<?= $config['base'] ?>/section_quiz_view.php?id=<?= $summary['fld_section_quiz_id'] ?>&student_id=<?= $summary['fld_student_id'] ?>"><?= $summary['fld_quiz'] ?></a></td>
                                    <?php endif ?>
                                    <td><?= $summary['fld_score'] .'/'. $summary['fld_total_questions'] .' ('. (100/$summary['fld_total_questions']) *$summary['fld_score'] .'%)' ?></td>
                                    <td><?= $summary['fld_date_summarized'] ?></td>
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
