<?php
require_once 'autoload.php';
$title = 'Quiz Edit';

if (Input::has('id'))
    $quizId = (int) Input::get('id');
else
    die('Not found!');

$subjects = $DB->fetchAll('SELECT * FROM tbl_subjects ORDER BY fld_name');
$quiz = $DB->fetch('SELECT * FROM tbl_quizzes WHERE fld_quiz_id = ?', [$quizId]);

require_once 'header.php' ?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Quiz Edit</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= $config['base'] ?>/quizzes.php">Quizzes</a></li>
                        <li><a href="<?= $config['base'] ?>/quiz_create.php">Create a Quiz</a></li>
                        <li><a href="<?= $config['base'] ?>/quiz_view.php?id=<?= $quizId ?>">Quiz View</a></li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <form action="<?= $config['base'] ?>/actions/quizzes/quiz_edit.php" method="post">
                        <input type="hidden" name="quiz_id" value="<?= $quiz['fld_quiz_id'] ?>">
                        <div class="form-group">
                            <label for="title">Title*</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="text" name="title" id="title" class="form-control" required value="<?= $quiz['fld_title'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject*</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <select class="form-control" data-toggle="select" data-live-search="true" name="subject" id="subject">
                                        <?php foreach ($subjects as $subject): ?>
                                            <?php if ($quiz['fld_subject_id'] == $subject['fld_subjet_id']): ?>
                                                <option value="<?= $subject['fld_subject_id'] ?>" required selected><?= ucfirst($subject['fld_name']) ?></option>
                                            <?php else: ?>
                                                <option value="<?= $subject['fld_subject_id'] ?>" required><?= ucfirst($subject['fld_name']) ?></option>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="instruction">Instruction</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <textarea name="instruction" class="form-control" id="instruction"><?= $quiz['fld_instruction'] ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="quiz_edit" class="btn btn-success pull-right"><i class="fa fa-check fa-fw"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<?php require_once 'footer.php' ?>
