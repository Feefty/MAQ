<?php
require_once 'autoload.php';
$title = 'Create a Registration Code';

$sectionId = null;
if (Input::has('section_id')) {
    $sectionId = (int) Input::get('section_id');
}

$sections = $DB->fetchAll('SELECT * FROM tbl_sections ORDER BY fld_name');

require_once 'header.php' ?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Create a Registration Code</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= $config['base'] ?>/registration_code.php">Registration Code</a></li>
                        <li class="active">Create a Registration Code</li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <form action="<?= $config['base'] ?>/actions/registration_codes/registration_code_create.php" method="post">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="number" name="amount" class="form-control" value="1" min="1" max="30">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <div class="row">
                                <div class="col-sm-12">
                                <label class="radio-inline">
                                    <input type="radio" name="role" value="student" checked>
                                    Student
                                </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="role" value="teacher">
                                        Teacher
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="section">Section</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <select class="form-control" name="section" id="section">
                                        <?php foreach ($sections as $section): ?>
                                            <?php if ($section['fld_section_id'] == $sectionId): ?>
                                                <option value="<?= $section['fld_section_id'] ?>" selected><?= $section['fld_name'] ?></option>
                                            <?php else: ?>
                                                <option value="<?= $section['fld_section_id'] ?>"><?= $section['fld_name'] ?></option>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="registration_code_create" class="btn btn-primary"><i class="fa fa-check fa-fw"></i> Create</button> <a href="<?= $config['base'] ?>/registration_code.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<?php require_once 'footer.php' ?>
