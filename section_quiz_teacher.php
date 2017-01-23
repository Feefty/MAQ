<?php
require_once 'autoload.php';

$Util->loginRequired();

if ($Util->getRole() == 'student') {
    die('Not found');
}

if (Input::has('id')) {
    $sectionQuizId = (int) Input::get('id');
} else {
    die('Not found!');
}

$section = $DB->fetch('SELECT *, tbl_subjects.fld_name as fld_subject FROM tbl_sections
                    LEFT JOIN tbl_section_quizzes ON tbl_section_quizzes.fld_section_id = tbl_sections.fld_section_id
                    LEFT JOIN tbl_quizzes ON tbl_quizzes.fld_quiz_id = tbl_section_quizzes.fld_quiz_id
                    LEFT JOIN tbl_subjects ON tbl_subjects.fld_subject_id = tbl_quizzes.fld_subject_id
                    WHERE tbl_section_quizzes.fld_section_quiz_id = ?',
                    [$sectionQuizId]);
$sectionId = $section['fld_section_id'];

$students = $DB->fetchAll('SELECT * FROM tbl_section_students
                        LEFT JOIN tbl_users ON tbl_users.fld_user_id = tbl_section_students.fld_user_id
                        LEFT JOIN tbl_profiles ON tbl_profiles.fld_profile_id = tbl_users.fld_profile_id
                        LEFT JOIN tbl_section_quiz_summaries ON tbl_section_quiz_summaries.fld_section_quiz_id = ?
                        WHERE tbl_section_students.fld_section_id = ?
                        ORDER BY tbl_section_quiz_summaries.fld_score DESC',
                        [$sectionQuizId, $sectionId]);



$title = 'Section Quiz View';
require_once 'header.php';
?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Section Quiz View</h1>
                    <ol class="breadcrumb">
                        <?php if ($Util->getRole() == 'admin'): ?>
                            <li><a href="<?= $config['base'] ?>/sections.php">Sections</a></li>
                            <li><a href="<?= $config['base'] ?>/section_create.php">Create a Section</a></li>
                        <?php else: ?>
                            <li><a href="<?= $config['base'] ?>/section_view.php">Section View</a></li>
                            <li><a href="<?= $config['base'] ?>/section_top_students.php?id=<?= $sectionId ?>">View Top 10 Students</a></li>
                        <?php endif ?>
                        <li class="active">Section Quiz View</li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <h2><?= $section['fld_name'] ?> <small><?=  $section['fld_course'] .' - '. $section['fld_year_level'] ?></small></h2>
                    <div class="well">
                        <h1 class="text-center"><?= $section['fld_title'] ?></h1>
                        <h4 class="text-center"><?= $section['fld_subject'] ?></h4>
                        <ul class="list-inline text-center">
                            <li><strong>Date Start:</strong> <?= $section['fld_start_on'] ?></li>
                            <li><strong>Date End:</strong> <?= $section['fld_end_on'] ?></li>
                        </ul>
                    </div>
                    <table data-toggle="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1 ?>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= ucwords($student['fld_first_name'] .' '. substr($student['fld_middle_name'], 0, 1) .'. '. $student['fld_last_name']) ?></td>
                                    <?php if ($student['fld_section_quiz_summary_id'] > 0): ?>
                                        <td><a href="<?= $config['base'] ?>/section_quiz_stats.php?id=<?= $sectionQuizId ?>&student_id=<?= $student['fld_student_id'] ?>"><?= number_format((100/$student['fld_total_questions'])*$student['fld_score'], 2) ?>%</a></td>
                                    <?php else: ?>
                                        <td><a href="<?= $config['base'] ?>/section_quiz_stats.php?id=<?= $sectionQuizId ?>&student_id=<?= $student['fld_student_id'] ?>" class="text-muted">Pending</a></td>
                                    <?php endif ?>
                                </tr>
                                <?php $i++ ?>
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
