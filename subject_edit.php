<?php
require_once 'autoload.php';
$title = 'Subject Edit';

if ($Util->getRole() != 'admin')
    die('Not allowed!');

if (Input::has('id')) {
    $subjectId = (int) Input::get('id');
} else {
    die('Not found!');
}

$subject = $DB->fetch('SELECT * FROM tbl_subjects WHERE fld_subject_id = ?', [$subjectId]);
require_once 'header.php' ?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Subject Edit</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= $config['base'] ?>/subjects.php">Subjects</a></li>
                        <li><a href="<?= $config['base'] ?>/subject_create.php">Create a Subject</a></li>
                        <li class="active">Subject Edit</li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <form action="<?= $config['base'] ?>/actions/subjects/subject_edit.php" method="post">
                        <input type="hidden" name="subject_id" value="<?= $subject['fld_subject_id'] ?>">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="text" name="name" id="name" class="form-control" required value="<?= $subject['fld_name'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <textarea name="description" id="description" class="form-control"><?= $subject['fld_description'] ?></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="subject_edit" class="btn btn-primary"><i class="fa fa-check fa-fw"></i> Save</button> <a href="<?= $config['base'] ?>/subjects.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<?php require_once 'footer.php' ?>
