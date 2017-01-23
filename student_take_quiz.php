<?php
require_once 'autoload.php';

$Util->loginRequired();

if ($Util->getRole() != 'student') {
    // delete schedule
    if (Input::has('action') && Input::has('delete_id') && Input::get('action') == 'delete_schedule') {
        $scheduleId = (int) Input::get('delete_id');
        $stmt = $DB->query('DELETE FROM tbl_schedules WHERE fld_schedule_id = ?')->getStatement();
        $stmt->execute([$scheduleId]);
        $Util->setMessage('Schedule deleted!');
        $Util->redirect('section_view.php?id='. $sectionId);
    }

    // delete student
    if (Input::has('action') && Input::has('delete_id') && Input::get('action') == 'delete_student') {
        $scheduleId = (int) Input::get('delete_id');
        $stmt = $DB->query('DELETE FROM tbl_section_students WHERE fld_section_student_id = ?')->getStatement();
        $stmt->execute([$scheduleId]);
        $Util->setMessage('Student deleted!');
        $Util->redirect('section_view.php?id='. $sectionId);
    }

    if ($Util->getRole() == 'teacher') {
        $sectionId = $DB->fetch('SELECT * FROM tbl_section_teachers WHERE fld_user_id = ?', [$_SESSION['fld_user_id']])['fld_section_id'];
    } else if (Input::has('id')) {
        $sectionId = (int) Input::get('id');
    } else {
        die('Not found!');
    }
} else {
    $sectionId = $DB->fetch('SELECT * FROM tbl_section_students WHERE fld_user_id = ?', [$_SESSION['fld_user_id']])['fld_section_id'];
}

$section = $DB->fetch('SELECT * FROM tbl_sections WHERE fld_section_id = ?', [$sectionId]);

if (!$section)
    die('Not found!');

$schedules = $DB->fetchAll('SELECT tbl_schedules.*, tbl_subjects.fld_name as fld_subject, tbl_rooms.fld_name as fld_room, CONCAT(tbl_profiles.fld_last_name,", ",tbl_profiles.fld_first_name,", ",tbl_profiles.fld_middle_name) as fld_teacher
                        FROM tbl_schedules
                        LEFT JOIN tbl_rooms ON tbl_rooms.fld_room_id = tbl_schedules.fld_room_id
                        LEFT JOIN tbl_subjects ON tbl_subjects.fld_subject_id = tbl_schedules.fld_subject_id
                        LEFT JOIN tbl_users ON tbl_users.fld_user_id = tbl_schedules.fld_user_id
                        LEFT JOIN tbl_profiles ON tbl_profiles.fld_profile_id = tbl_users.fld_profile_id
                        WHERE fld_section_id = ?' , [$sectionId]);
$students = $DB->fetchAll('SELECT * FROM tbl_section_students
                        LEFT JOIN tbl_users ON tbl_users.fld_user_id = tbl_section_students.fld_user_id
                        LEFT JOIN tbl_profiles ON tbl_profiles.fld_profile_id = tbl_users.fld_profile_id
                        WHERE fld_section_id = ?', [$sectionId]);

$quizzes = $DB->fetchAll('SELECT tbl_section_quizzes.*, tbl_quizzes.fld_title as fld_quiz FROM tbl_section_quizzes
                        LEFT JOIN tbl_quizzes ON tbl_quizzes.fld_quiz_id = tbl_section_quizzes.fld_quiz_id
                        WHERE fld_section_id = ? GROUP BY tbl_quizzes.fld_quiz_id', [$sectionId]);

$title = 'Section View';
require_once 'header.php';
?>
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Take A Quiz</h1>
                    <ol class="breadcrumb">
                        <?php if ($Util->getRole() == 'admin'): ?>
                            
                        <?php endif ?>
                        <li class="active">My Quizzes</li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <h3>Quizzes</h3>
                    <div id="quiz-toolbar">
                        <?php if ($Util->getRole() != 'student'): ?>
                            <a href="<?= $config['base'] ?>/launch.php?section_id=<?= $sectionId ?>" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Launch a Quiz</a>
                        <?php endif ?>
                    </div>
                    <table data-toolbar="#quiz-toolbar" data-toggle="table" data-pagination="true" data-search="true">
                        <thead>
                            <tr>
                                <th>Quiz</th>
                                <th>Date Start</th>
                                <th>Date End</th>
                                <th>Status</th>
                                <?php if ($Util->getRole() != 'student'): ?>
                                    <th>Edit</th>
                                <?php endif ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($quizzes as $quiz): ?>
                                <tr>
                                    <?php if ($Util->getRole() == 'student'): ?>
                                        <td><a href="<?= $config['base'] ?>/section_quiz_view.php?id=<?= $quiz['fld_section_quiz_id'] ?>&student_id=<?= $_SESSION['fld_student_id'] ?>"><?= $quiz['fld_quiz'] ?></a></td>
                                    <?php else: ?>
                                        <td><a href="<?= $config['base'] ?>/section_quiz_teacher.php?id=<?= $quiz['fld_section_quiz_id'] ?>"><?= $quiz['fld_quiz'] ?></a></td>
                                    <?php endif ?>
                                    <td><?= $quiz['fld_start_on'] ?></td>
                                    <td><?= $quiz['fld_end_on'] ?></td>
                                    <td><?= $quiz['fld_status'] ? 'Active' : 'Inactive' ?></td>
                                    <?php if ($Util->getRole() != 'student'): ?>
                                        <td><a href="<?= $config['base'] ?>/section_quiz_edit.php?id=<?= $quiz['fld_section_quiz_id'] ?>"><i class="fa fa-pencil fa-fw"></i></a></td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<?php require_once 'footer.php' ?>
