<?php
require_once 'autoload.php';
$title = 'Create a Schedule';

if (Input::has('section_id')) {
    $sectionId = (int) Input::get('section_id');
} else {
    die('Not found!');
}

$rooms = $DB->fetchAll('SELECT * FROM tbl_rooms');
$teachers = $DB->fetchAll('SELECT * FROM tbl_users LEFT JOIN tbl_profiles ON tbl_profiles.fld_profile_id = tbl_users.fld_profile_id WHERE fld_role = "teacher"');
$subjects = $DB->fetchAll('SELECT * FROM tbl_subjects ORDER BY fld_name');

require_once 'header.php' ?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Create a Schedule</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= $config['base'] ?>/sections.php">Sections</a></li>
                        <li><a href="<?= $config['base'] ?>/section_create.php">Create a Section</a></li>
                        <li><a href="<?= $config['base'] ?>/section_view.php?id=<?= $sectionId ?>">Section View</a></li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <form action="<?= $config['base'] ?>/actions/schedules/schedule_create.php" method="post">
                        <input type="hidden" name="section_id" value="<?= $sectionId ?>">
                        <div class="form-group">
                            <label>Time*</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">Start</span>
                                        <input type="time" name="time_start" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">End</span>
                                        <input type="time" name="time_end" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="day">Day*</label>
                                </div>
                                <div class="col-sm-6">
                                    <label for="room">Room*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <select class="form-control" name="day" id="day">
                                        <?php foreach ($config['days'] as $day): ?>
                                            <option value="<?= $day ?>"><?= $day ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-control" name="room" id="room" required>
                                        <?php foreach ($rooms as $room): ?>
                                            <option value="<?= $room['fld_room_id'] ?>"><?= $room['fld_name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject*</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <select class="form-control" name="subject" id="subject" required>
                                        <?php foreach ($subjects as $subject): ?>
                                            <option value="<?= $subject['fld_subject_id'] ?>"><?= $subject['fld_name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="teacher">Teacher*</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <select class="form-control" name="teacher" id="teacher" required>
                                        <?php foreach ($teachers as $teacher): ?>
                                            <option value="<?= $teacher['fld_user_id'] ?>"><?= $teacher['fld_last_name'] .', '. $teacher['fld_first_name'] .', '. $teacher['fld_middle_name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="schedule_create" class="btn btn-primary"><i class="fa fa-check fa-fw"></i> Create</button> <a href="<?= $config['base'] ?>/section_view.php?id=<?= $sectionId ?>" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<?php require_once 'footer.php' ?>
