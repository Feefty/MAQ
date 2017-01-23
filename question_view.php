<?php
require_once 'autoload.php';
$title = 'Quiz Question View';

if (Input::has('id'))
    $questionId = (int) Input::get('id');
else
    die('Not found!');

$question = $DB->fetch('SELECT * FROM tbl_quiz_questions
                        LEFT JOIN tbl_quizzes ON tbl_quizzes.fld_quiz_id = tbl_quiz_questions.fld_quiz_id
                        WHERE tbl_quiz_questions.fld_quiz_question_id = ?',
                        [$questionId]);

$question['fld_answers'] = $DB->fetchAll('SELECT * FROM tbl_quiz_question_answers WHERE fld_quiz_question_id = ?',
                                [$question['fld_quiz_question_id']]);

require_once 'header.php' ?>

    <div class="col-sm-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <h1>Quiz Question View</h1>
                <ol class="breadcrumb">
                    <li><a href="<?= $config['base'] ?>/quizzes.php">Quizzes</a></li>
                    <li><a href="<?= $config['base'] ?>/quiz_create.php">Create a Quiz</a></li>
                    <li class="active">Quiz View</li>
                </ol>
                <?= $Util->printMessage() ?>
                <?= $Util->printError() ?>
                <h2><a href="<?= $config['base'] ?>/quiz_view.php?id=<?= $question['fld_quiz_id'] ?>"><?= $question['fld_title'] ?></a></h2>
                <p><?= $question['fld_instruction'] ?></p>
                <h4><?= $config['question']['categories'][$question['fld_category']] ?></h4>
                <div class="well">
                    <?= $question['fld_question'] ?>
                </div>
                <?php if ($question['fld_category'] == 'sa'): ?>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-check text-success"></i></span>
                            <input type="text" disabled class="form-control" value="<?= $question['fld_answers'][0]['fld_answer'] ?>">
                        </div>
                    </div>
                <?php elseif ($question['fld_category'] == 'mc'): ?>
                    <?php foreach ($question['fld_answers'] as $answer): ?>
                        <div class="form-group">
                            <div class="input-group">
                                <?php if ($answer['fld_correct'] == 1): ?>
                                    <span class="input-group-addon"><i class="fa fa-check text-success"></i></span>
                                <?php else: ?>
                                    <span class="input-group-addon"><input type="radio" disabled></span>
                                <?php endif ?>
                                <input type="text" disabled value="<?= $answer['fld_answer'] ?>" class="form-control">
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php elseif ($question['fld_category'] == 'tf'): ?>
                    <ul class="list-unstyled">
                        <?php if ($question['fld_answers'][0]['fld_answer'] == 'true'): ?>
                            <li><label><i class="fa fa-check text-success"></i> True</label></li>
                            <li><label><input type="radio" disabled> False</label></li>
                        <?php else: ?>
                            <li><label><input type="radio" disabled> True</label></li>
                            <li><label><i class="fa fa-check text-success"></i> False</label></li>
                        <?php endif ?>
                    </ul>
                <?php elseif ($question['fld_category'] == 'cb'): ?>
                    <?php foreach ($question['fld_answers'] as $answer): ?>
                        <div class="form-group">
                            <div class="input-group">
                                <?php if ($answer['fld_correct'] == 1): ?>
                                    <span class="input-group-addon"><i class="fa fa-check text-success"></i></span>
                                <?php else: ?>
                                    <span class="input-group-addon"><i class="fa fa-arrow-right"></i></span>
                                <?php endif ?>
                                <input type="text" class="form-control" value="<?= $answer['fld_answer'] ?>" disabled>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php elseif ($question['fld_category'] == 'mt'): ?>
                    <?php for ($i = 0; $i < count($question['fld_answers']); $i+=2): ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?= $question['fld_answers'][$i]['fld_answer'] ?>" disabled>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?= $question['fld_answers'][$i+1]['fld_answer'] ?>" disabled>
                                </div>
                            </div>
                        </div>
                    <?php endfor ?>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <?php require_once 'sidebar.php' ?>
    </div>

<?php require_once 'footer.php' ?>
