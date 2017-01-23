<?php
require_once 'autoload.php';
$title = 'Quizzes';

if ($Util->getRole() == 'student')
    die('Not allowed!');

$sql = 'SELECT tbl_quizzes.*, tbl_subjects.fld_name as fld_subject FROM tbl_quizzes
        LEFT JOIN tbl_subjects ON tbl_subjects.fld_subject_id = tbl_quizzes.fld_subject_id';
$data = [];

if ($Util->getRole() == 'teacher') {
    $sql .= ' WHERE tbl_quizzes.fld_user_id = ?';
    $data[] = $_SESSION['fld_user_id'];
}
$quizzes = $DB->fetchAll($sql, $data);
require_once 'header.php' ?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Quizzes</h1>
                    <ol class="breadcrumb">
                        <li class="active">Quizzes</li>
                        <li><a href="<?= $config['base'] ?>/quiz_create.php">Create a Quiz</a></li>
                    </ol>
                    <table data-toggle="table" data-pagination="true" data-search="true">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Subject</th>
                                <th>Instruction</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($quizzes as $quiz): ?>
                                <tr>
                                    <td><a href="<?= $config['base'] ?>/quiz_view.php?id=<?= $quiz['fld_quiz_id'] ?>"><?= $quiz['fld_title'] ?></a></td>
                                    <td><?= $quiz['fld_subject'] ?></td>
                                    <td><?= $quiz['fld_instruction'] ?></td>
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
