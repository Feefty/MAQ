<?php
require_once 'autoload.php';
$title = 'Quiz View';

if (Input::has('id'))
    $quizId = (int) Input::get('id');
else
    die('Not found!');

if (Input::has('action') && Input::has('delete_id') && Input::get('action') == 'delete') {
    $questionId = (int) Input::get('delete_id');
    $stmt = $DB->query('DELETE FROM tbl_quiz_questions WHERE fld_quiz_question_id = ?')->getStatement();
    $stmt->execute([$questionId]);
    $Util->setMessage('Question deleted!');
    $Util->redirect('quiz_view.php?id='. $quizId);
}

$quiz = $DB->fetch('SELECT tbl_quizzes.*, tbl_subjects.fld_name as fld_subject FROM tbl_quizzes
                    LEFT JOIN tbl_subjects ON tbl_subjects.fld_subject_id = tbl_quizzes.fld_subject_id
                    WHERE fld_quiz_id = ?', [$quizId]);
$questions = $DB->fetchAll('SELECT * FROM tbl_quiz_questions WHERE fld_quiz_id = ?', [$quizId]);

require_once 'header.php' ?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Quiz View</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= $config['base'] ?>/quizzes.php">Quizzes</a></li>
                        <li><a href="<?= $config['base'] ?>/quiz_create.php">Create a Quiz</a></li>
                        <li class="active">Quiz View</li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <h2><?= $quiz['fld_title'] ?></h2>
                    <p><?= $quiz['fld_instruction'] ?></p>
                    <div id="toolbar">
                        <a href="<?= $config['base'] ?>/quiz_edit.php?id=<?= $quizId ?>" class="btn btn-primary"><i class="fa fa-pencil fa-fw"></i> Edit Quiz</a>
                        <span class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="add-question-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="fa fa-plus fa-fw"></i> Add Question
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="add-question-dropdown">
                                <li><a href="#" data-toggle="modal" data-target="#add-question-modal" data-question-category="mc">Multiple Choice</a></li>
                                <li><a href="#" data-toggle="modal" data-target="#add-question-modal" data-question-category="tf">True / False</a></li>
                                <li><a href="#" data-toggle="modal" data-target="#add-question-modal" data-question-category="sa">Short Answer</a></li>
                                <li><a href="#" data-toggle="modal" data-target="#add-question-modal" data-question-category="fb">Fill in the Blank</a></li>
                                <li><a href="#" data-toggle="modal" data-target="#add-question-modal" data-question-category="cb">Checkboxes</a></li>
                                <li><a href="#" data-toggle="modal" data-target="#add-question-modal" data-question-category="mt">Matching Type</a></li>
                                <li><a href="#" data-toggle="modal" data-target="#add-question-modal" data-question-category="ew">Essay Writing</a></li>
                            </ul>
                        </span>
                    </div>
                    <table data-toggle="table" data-toolbar="#toolbar" data-pagination="true" data-search="true">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Category</th>
                                <th>View</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($questions as $question): ?>
                                <tr>
                                    <td><?= $question['fld_question'] ?></td>
                                    <td><?= $config['question']['categories'][$question['fld_category']] ?></td>
                                    <td><a href="<?= $config['base'] ?>/question_view.php?id=<?= $question['fld_quiz_question_id'] ?>"><i class="fa fa-eye"></i></a></td>
                                    <td><a href="<?= $config['base'] ?>/quiz_view.php?id=<?= $question['fld_quiz_id'] ?>&action=delete&delete_id=<?= $question['fld_quiz_question_id'] ?>"><i class="fa fa-times"></i></a></td>
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


<div class="modal fade" id="add-question-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus fa-fw"></i> Add Question</h4>
            </div>
            <form action="<?= $config['base'] ?>/actions/questions/question_create.php" method="post">
                <input type="hidden" name="quiz_id" value="<?= $quizId ?>">
                <div class="modal-body">
                    <div class="question"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="question_create" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once 'footer.php' ?>
