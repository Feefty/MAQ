<?php
require_once 'autoload.php';

$Util->loginRequired();

if (Input::has('id')) {
    $sectionId = (int) Input::get('id');
} else {
    die('Not found');
}

$section = $DB->fetch('SELECT * FROM tbl_sections WHERE fld_section_id = ?', [$sectionId]);

if (!$section)
    die('Not found!');

$topStudents = $DB->fetchAll('SELECT *, AVG(tbl_section_quiz_summaries.fld_score*(100/tbl_section_quiz_summaries.fld_total_questions)) as fld_average_grade FROM tbl_section_students
                            LEFT JOIN tbl_users ON tbl_users.fld_user_id = tbl_section_students.fld_user_id
                            LEFT JOIN tbl_profiles ON tbl_profiles.fld_profile_id = tbl_users.fld_profile_id
                            LEFT JOIN tbl_section_quizzes ON tbl_section_quizzes.fld_section_id = tbl_section_students.fld_section_id
                            LEFT JOIN tbl_section_quiz_summaries ON tbl_section_quiz_summaries.fld_section_quiz_id = tbl_section_quizzes.fld_section_quiz_id
                            WHERE tbl_section_students.fld_section_id = ?
                            GROUP BY tbl_section_students.fld_user_id
                            ORDER BY AVG(tbl_section_quiz_summaries.fld_score*(100/tbl_section_quiz_summaries.fld_total_questions)) DESC
                            LIMIT 10',
                            [$sectionId]);

$title = 'View Top 10 Students';
require_once 'header.php';
?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>View Top 10 Students</h1>
                    <ol class="breadcrumb">
                        <?php if ($Util->getRole() == 'admin'): ?>
                            <li><a href="<?= $config['base'] ?>/sections.php">Sections</a></li>
                            <li><a href="<?= $config['base'] ?>/section_create.php">Create a Section</a></li>
                        <?php else: ?>
                            <li><a href="<?= $config['base'] ?>/section_view.php">Section View</a></li>
                            <li class="active">View Top 10 Students</li>
                        <?php endif ?>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <h2><?= $section['fld_name'] ?> <small><?=  $section['fld_course'] .' - '. $section['fld_year_level'] ?></small></h2>

                    <table data-toggle="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Average Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($topStudents as $topStudent): ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= ucwords($topStudent['fld_first_name'] .' '. substr($topStudent['fld_middle_name'], 0, 1) .'. '. $topStudent['fld_last_name']) ?></td>
                                    <td><?= number_format($topStudent['fld_average_grade'], 2) ?>%</td>
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
