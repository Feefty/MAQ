<?php
require_once 'autoload.php';

if (Input::has('id') && $Util->getRole() == 'student') {
    $sectionQuizId = (int) Input::get('id');
    $studentId = $_SESSION['fld_student_id'];
} else {
    die('Not found!');
}

$sectionQuiz = $DB->fetch('SELECT *, tbl_subjects.fld_name as fld_subject FROM tbl_section_quizzes
                LEFT JOIN tbl_quizzes ON tbl_quizzes.fld_quiz_id = tbl_section_quizzes.fld_quiz_id
                LEFT JOIN tbl_subjects ON tbl_subjects.fld_subject_id = tbl_quizzes.fld_subject_id
                LEFT JOIN tbl_section_students ON tbl_section_students.fld_section_id = tbl_section_quizzes.fld_section_id
                LEFT JOIN tbl_users ON tbl_users.fld_user_id = tbl_section_students.fld_user_id
                WHERE tbl_section_quizzes.fld_section_quiz_id = ?',
                [$sectionQuizId]);

if (!$sectionQuiz) {
    die('Not found!');
}

$totalQuestions = $DB->fetchAll('SELECT * FROM tbl_quiz_questions
                                WHERE fld_quiz_id = ?', [$sectionQuiz['fld_quiz_id']]);
$questionAnswered = $DB->fetch('SELECT COUNT(*) as fld_correct_answers, fld_date_answered FROM tbl_section_quiz_student_answers
            WHERE fld_section_quiz_id = ? AND fld_section_student_id = ? AND fld_correct = 1',
            [$sectionQuizId, $sectionQuiz['fld_section_student_id']]);
$questions = $DB->fetchAll('SELECT * FROM tbl_section_quizzes
                        LEFT JOIN tbl_quiz_questions ON tbl_quiz_questions.fld_quiz_id = tbl_section_quizzes.fld_quiz_id
                        WHERE tbl_section_quizzes.fld_section_quiz_id = ? AND
                            EXISTS (SELECT * FROM tbl_section_students
                                    LEFT JOIN tbl_users ON tbl_users.fld_user_id = tbl_section_students.fld_user_id
                                    LEFT JOIN tbl_profiles ON tbl_profiles.fld_profile_id = tbl_users.fld_profile_id
                                    WHERE tbl_section_students.fld_section_id = tbl_section_quizzes.fld_section_id
                                        AND tbl_profiles.fld_student_id = ? AND
                                        NOT EXISTS (SELECT * FROM tbl_section_quiz_student_answers
                                                WHERE tbl_section_quiz_student_answers.fld_quiz_question_id = tbl_quiz_questions.fld_quiz_question_id
                                                    AND tbl_section_quiz_student_answers.fld_section_student_id = tbl_section_students.fld_section_student_id))',
                            [$sectionQuizId, $studentId], PDO::FETCH_OBJ);

$summary = $DB->fetch('SELECT COUNT(*) as fld_summary_exists FROM tbl_section_quiz_summaries
            WHERE fld_section_quiz_id = ? AND fld_section_student_id = ?',
            [$sectionQuizId, $sectionQuiz['fld_section_student_id']]);

$title = 'Section Quiz View';
require_once 'header.php';
?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <h1 class="text-center"><?= $sectionQuiz['fld_title'] ?></h1>
                    <h4 class="text-center"><?= $sectionQuiz['fld_subject'] ?></h4>
                    <ul class="list-inline text-center">
                        <li><strong>Date Start:</strong> <?= $sectionQuiz['fld_start_on'] ?></li>
                        <li><strong>Date End:</strong> <?= $sectionQuiz['fld_end_on'] ?></li>
                    </ul>
                    <?php if (count($questions) > 0): ?>
                        <?php if (strtotime($sectionQuiz['fld_start_on']) < time() && strtotime($sectionQuiz['fld_end_on']) > time()): ?>
                            <p class="text-center"><a href="<?= $config['base'] ?>/section_quiz.php?id=<?= $sectionQuizId ?>" class="btn btn-primary"><i class="fa fa-play fa-fw"></i> Start Answering!</a></p>
                        <?php else: ?>
                            <p class="text-center">Check the schedule</p>
                        <?php endif ?>
                    <?php else: ?>
                        <?php if ($summary['fld_summary_exists'] > 0): ?>
                            <ul class="list-inline text-center">
                                <li><strong>Score:</strong> <?= $questionAnswered['fld_correct_answers'] ?> (<?= round((100 / count($totalQuestions))*$questionAnswered['fld_correct_answers']) ?>%)</li>
                                <li><strong>Total Question:</strong> <?= count($totalQuestions) ?></li>
                                <li><strong>Date Finished:</strong> <?= $questionAnswered['fld_date_answered'] ?: 'N/A' ?></li>
                            </ul>
                        <?php else: ?>
                            <div class="well text-center">
                                Waiting for your teacher to check your Essay Writing
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<?php require_once 'footer.php' ?>
