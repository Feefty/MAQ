<?php
require_once 'autoload.php';

if ($Util->getRole() != 'admin')
    die('Not allowed!');

$title = 'Create a Subject';
?>
<?php require_once 'header.php' ?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Create a Subject</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= $config['base'] ?>/subjects.php">Subjects</a></li>
                        <li class="active">Create a Subject</li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <form action="<?= $config['base'] ?>/actions/subjects/subject_create.php" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <textarea name="description" id="description" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="subject_create" class="btn btn-primary"><i class="fa fa-check fa-fw"></i> Create</button> <a href="<?= $config['base'] ?>/subjects.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<?php require_once 'footer.php' ?>
