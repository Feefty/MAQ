<?php
require_once 'autoload.php';
$title = 'Create a Quiz';
$subjects = $DB->fetchAll('SELECT * FROM tbl_subjects ORDER BY fld_name');
require_once 'header.php' ?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Create a Quiz</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= $config['base'] ?>/quizzes.php">Quizzes</a></li>
                        <li class="active">Create a Quiz</li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <form action="<?= $config['base'] ?>/actions/quizzes/quiz_create.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title*</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject*</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <select class="form-control" data-toggle="select" data-live-search="true" name="subject" id="subject">
                                        <?php foreach ($subjects as $subject): ?>
                                            <option value="<?= $subject['fld_subject_id'] ?>" required><?= ucfirst($subject['fld_name']) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="instruction">Instruction</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <textarea name="instruction" class="form-control" id="instruction"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h3>Questions</h3>
                            <div class="question"></div>
                            <span class="dropdown dropup">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-plus fa-fw"></i> Add Question
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="add-question-dropdown">
                                    <li><a href="javascript:void(0)" onclick="return addQuestion('mc')">Multiple Choice</a></li>
                                    <li><a href="javascript:void(0)" onclick="return addQuestion('tf')">True / False</a></li>
                                    <li><a href="javascript:void(0)" onclick="return addQuestion('sa')">Short Answer</a></li>
                                    <li><a href="javascript:void(0)" onclick="return addQuestion('fb')">Fill in the Blank</a></li>
                                    <li><a href="javascript:void(0)" onclick="return addQuestion('mt')">Matching Type</a></li>
                                    <li><a href="javascript:void(0)" onclick="return addQuestion('cb')">Checkboxes</a></li>
                                    <li><a href="javascript:void(0)" onclick="return addQuestion('ew')">Essay Writing</a></li>
                                </ul>
                            </span>
                            <button type="submit" name="quiz_create" class="btn btn-success pull-right"><i class="fa fa-check fa-fw"></i> Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<?php require_once 'footer.php' ?>
