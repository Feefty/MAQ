<?php
require_once 'autoload.php';
$user = $_SESSION;
$Util->loginRequired();

$profile = $_SESSION;
?>
<?php require_once 'header.php' ?>

        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Profile Edit</h1>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <form action="<?= $config['base'] ?>/actions/profiles/profile_edit.php" method="post">
                        <input type="hidden" name="profile_id" value="<?= $profile['profile_id'] ?>">
                        <div class="form-group">
                            <label for="first_name">First Name*</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" value="<?= $profile['fld_first_name'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name*</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" value="<?= $profile['fld_last_name'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="middle_name">Middle Name*</label>
                            <input type="text" name="middle_name" id="middle_name" class="form-control" value="<?= $profile['fld_middle_name'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender*</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php if ($profile['fld_gender'] != 'female'): ?>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="male" required checked>
                                            Male
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="female" required>
                                            Female
                                        </label>
                                    <?php else: ?>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="male" required>
                                            Male
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="female" required checked>
                                            Female
                                        </label>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact_no">Contact No.</label>
                            <input type="text" name="contact_no" id="contact_no" class="form-control" value="<?= $profile['fld_contact_no'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" class="form-control"><?= $profile['fld_address'] ?></textarea>
                        </div>
                        <?php if ($Util->getRole() == 'student'): ?>
                            <div class="form-group">
                                <label for="student_id">Student ID*</label>
                                <input type="text" name="student_id" id="student_id" class="form-control" value="<?= $profile['fld_student_id'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="student_id">Year Level*</label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?php if ($profile['fld_year_level'] == 1): ?>
                                            <label class="radio-inline">
                                                <input type="radio" name="year_level" value="1" checked>
                                                First Year
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="year_level" value="2">
                                                Second Year
                                            </label>
                                        <?php else: ?>
                                            <label class="radio-inline">
                                                <input type="radio" name="year_level" value="1">
                                                First Year
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="year_level" value="2" checked>
                                                Second Year
                                            </label>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="course">Course*</label>
                                <select class="form-control" name="course" id="course">
                                    <?php foreach ($config['courses'] as $course): ?>
                                        <?php if ($course == $profile['fld_course']): ?>
                                            <option value="<?= $course ?>" selected><?= $course ?></option>
                                        <?php else: ?>
                                            <option value="<?= $course ?>"><?= $course ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        <?php endif ?>
                        <button type="submit" name="profile_edit" class="btn btn-primary"><i class="fa fa-check fa-fw"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>

<?php require_once 'footer.php' ?>
