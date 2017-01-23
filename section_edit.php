<?php
require_once 'autoload.php';
$title = 'Section Edit';

if ($Util->getRole() != 'admin')
    die('Not allowed!');

if (Input::has('id')) {
    $sectionId = (int) Input::get('id');
} else {
    die('Not found!');
}

$section = $DB->fetch('SELECT * FROM tbl_sections WHERE fld_section_id = ?', [$sectionId]);

require_once 'header.php' ?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Section Edit</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= $config['base'] ?>/sections.php">Sections</a></li>
                        <li><a href="<?= $config['base'] ?>/section_create.php">Create a Section</a></li>
                        <li class="active">Section Edit</li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <form action="<?= $config['base'] ?>/actions/sections/section_edit.php" method="post">
                        <input type="hidden" name="section_id" value="<?= $section['fld_section_id'] ?>">
                        <div class="form-group">
                            <label for="name">Name*</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="text" name="name" id="name" class="form-control" value="<?= $section['fld_name'] ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="year_level">Year Level*</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php if ($section['fld_year_level'] == 1): ?>
                                        <label class="radio-inline">
                                            <input type="radio" name="year_level" value="1" checked required>
                                            First Year
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="year_level" value="2" required>
                                            Second Year
                                        </label>
                                    <?php else: ?>
                                        <label class="radio-inline">
                                            <input type="radio" name="year_level" value="1" required>
                                            First Year
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="year_level" value="2" checked required>
                                            Second Year
                                        </label>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="course">Course*</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <select class="form-control" name="course" required>
                                        <?php foreach ($config['courses'] as $course): ?>
                                            <?php if ($section['fld_course'] == $course): ?>
                                                <option value="<?= $course ?>" selected><?= $course ?></option>
                                            <?php else: ?>
                                                <option value="<?= $course ?>"><?= $course ?></option>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="section_edit" class="btn btn-primary"><i class="fa fa-check fa-fw"></i> Save</button> <a href="<?= $config['base'] ?>/sections.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<?php require_once 'footer.php' ?>
