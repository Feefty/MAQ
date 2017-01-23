<?php
require_once 'autoload.php';
$title = 'Launch';

if ($Util->getRole() == 'student') {
    die('Not allowed!');
}

$sql = 'SELECT * FROM tbl_quizzes ';
$data = [];

if ($Util->getRole() == 'teacher') {
    $sql .= 'WHERE fld_user_id = ? ';
    $data[] = $_SESSION['fld_user_id'];
}

$sql .= 'ORDER BY fld_title';

$quizzes = $DB->fetchAll($sql, $data);

$sql = 'SELECT * FROM tbl_sections ';
if ($Util->getRole() == 'teacher') {
    $sql .= ' LEFT JOIN tbl_section_teachers ON tbl_section_teachers.fld_section_id = tbl_sections.fld_section_id
            WHERE tbl_section_teachers.fld_user_id = ? ';
}
$sql .= 'ORDER BY tbl_sections.fld_name';
$sections = $DB->fetchAll($sql, $data);

$sectionId = Input::get('section_id');

require_once 'header.php' ?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading"><h2><i class="fa fa-rocket fa-fw"></i> Launch</h2></div>
                <div class="panel-body">
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-8">
                            <form action="<?= $config['base'] ?>/actions/quizzes/launch.php" method="post">
                                <div class="form-group">
                                    <label for="section">Section</label>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <select class="form-control" data-toggle="select" data-live-search="true" name="section" id="section">
                                                <?php foreach ($sections as $section): ?>
                                                    <?php if ($section['fld_section_id'] == $sectionId): ?>
                                                        <option value="<?= $section['fld_section_id'] ?>" selected><?= $section['fld_name'] .' : '. $section['fld_course'] .' - '. $section['fld_year_level'] ?></option>
                                                    <?php else: ?>
                                                        <option value="<?= $section['fld_section_id'] ?>"><?= $section['fld_name'] .' : '. $section['fld_course'] .' - '. $section['fld_year_level'] ?></option>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="quiz">Quiz</label>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <select class="form-control" data-toggle="select" data-live-search="true" name="quiz" id="quiz">
                                                <?php foreach ($quizzes as $quiz): ?>
                                                    <option value="<?= $quiz['fld_quiz_id'] ?>"><?= $quiz['fld_title'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="start">Starting Date</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="start">Ending Date</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="datetime-local" name="start" id="start_on" class="form-control">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="datetime-local" name="end" id="end_on" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="submit" name="launch" class="form-control btn btn-primary"><i class="fa fa-hourglass-start"></i> Start</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<?php require_once 'footer.php' ?>
