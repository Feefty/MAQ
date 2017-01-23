<?php
require_once 'autoload.php';
if ($Util->getRole() != 'admin')
    die('Not allowed!');

$title = 'Create a Section';
?>
<?php require_once 'header.php' ?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Create a Section</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= $config['base'] ?>/sections.php">Sections</a></li>
                        <li class="active">Create a Section</li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <form action="<?= $config['base'] ?>/actions/sections/section_create.php" method="post">
                        <div class="form-group">
                            <label for="name">Name*</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="year_level">Year Level*</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="radio-inline">
                                        <input type="radio" name="year_level" value="1" checked required>
                                        First Year
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="year_level" value="2" required>
                                        Second Year
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="course">Course*</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <select class="form-control" name="course" required>
                                        <?php foreach ($config['courses'] as $course): ?>
                                            <option value="<?= $course ?>"><?= $course ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="section_create" class="btn btn-primary"><i class="fa fa-check fa-fw"></i> Create</button> <a href="<?= $config['base'] ?>/sections.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>
        
<?php require_once 'footer.php' ?>
