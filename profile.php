<?php
require_once 'autoload.php';
$user = $_SESSION;
$Util->loginRequired();

if ($Util->getRole() == 'student') {
    $section = $DB->fetch('SELECT * FROM tbl_section_students
                        LEFT JOIN tbl_sections ON tbl_sections.fld_section_id = tbl_section_students.fld_section_id
                        WHERE tbl_section_students.fld_user_id = ?',
                        [$user['fld_user_id']]);
}
?>
<?php require_once 'header.php' ?>

        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= ucwords($user['fld_first_name'] .' '. substr($user['fld_middle_name'], 0, 1) .'. '. $user['fld_last_name']) ?>'s Profile
                        <?php if ($user['fld_user_id'] == @$_SESSION['fld_user_id']): ?>
                        <a href="<?= $config['base'] ?>/profile_edit.php" class="pull-right"><i class="fa fa-pencil"></i></a>
                    <?php endif ?>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <th>Role:</th>
                            <td><?= ucfirst($user['fld_role']) ?></td>
                        </tr>
                        <tr>
                            <th>Last Logged In:</th>
                            <td><?= $user['fld_last_login'] ?></td>
                        </tr>
                        <tr>
                            <th>Joined:</th>
                            <td><?= $user['fld_joined'] ?></td>
                        </tr>
                        <tr>
                            <th>Gender:</th>
                            <td><?= ucwords($user['fld_gender']) ?></td>
                        </tr>
                        <tr>
                            <th>Contact No#:</th>
                            <td><?= $user['fld_contact_no'] ?></td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td><?= $user['fld_address'] ?></td>
                        </tr>
                        <?php if ($Util->getRole() == 'student'): ?>
                            <tr>
                                <th>Course:</th>
                                <td><?= $user['fld_course'] ?></td>
                            </tr>
                            <tr>
                                <th>Student ID#:</th>
                                <td><?= $user['fld_student_id'] ?></td>
                            </tr>
                            <tr>
                                <th>Year Level:</th>
                                <td><?= $user['fld_year_level'] + 10 ?></td>
                            </tr>
                            <tr>
                                <th>Section:</th>
                                <td><a href="<?= $config['base'] ?>/section_view.php?id=<?= $section['fld_section_id'] ?>"><?= $section['fld_name'] ?></a></td>
                            </tr>
                        <?php endif ?>
                    </table>
                </div>
            </div>
        </div>

<?php require_once 'footer.php' ?>
