<?php
require_once 'autoload.php';

if (Input::has('id') && Input::has('student_id')) {
    $sectionQuizId = (int) Input::get('id');
    $studentId = Input::get('student_id');
} else {
    die('Not found!');
}

$sectionQuiz = $DB->fetch('SELECT *, tbl_subjects.fld_name as fld_subject FROM tbl_section_quizzes
                LEFT JOIN tbl_quizzes ON tbl_quizzes.fld_quiz_id = tbl_section_quizzes.fld_quiz_id
                LEFT JOIN tbl_subjects ON tbl_subjects.fld_subject_id = tbl_quizzes.fld_subject_id
                LEFT JOIN tbl_section_students ON tbl_section_students.fld_section_id = tbl_section_quizzes.fld_section_id
                LEFT JOIN tbl_users ON tbl_users.fld_user_id = tbl_section_students.fld_user_id
                LEFT JOIN tbl_profiles ON tbl_profiles.fld_profile_id = tbl_users.fld_profile_id
                WHERE tbl_section_quizzes.fld_section_quiz_id = ? AND tbl_profiles.fld_student_id = ?',
                [$sectionQuizId, $studentId]);

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

$records = [];
for ($i = 0; $i < count($totalQuestions); $i++) {
    $records[$i] = $totalQuestions[$i];

    $answers = $DB->fetchAll('SELECT * FROM tbl_quiz_question_answers WHERE fld_quiz_question_id = ? ORDER BY fld_order',
                            [$records[$i]['fld_quiz_question_id']]);
    $records[$i]['fld_answers'] = $answers;
    $studentAnswers = $DB->fetchAll('SELECT * FROM tbl_section_quiz_student_answers WHERE fld_quiz_question_id = ? ORDER BY fld_order',
                            [$records[$i]['fld_quiz_question_id']]);
    $records[$i]['fld_student_answers'] = $studentAnswers;
}

$title = 'Section Quiz Stats';
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
                        <div class="alert alert-warning">
                            Have not yet taken
                        </div>
                    <?php else: ?>
                        <ul class="list-inline text-center">
                            <li><strong>Score:</strong> <?= $questionAnswered['fld_correct_answers'] ?> (<?= round((100 / count($totalQuestions))*$questionAnswered['fld_correct_answers']) ?>%)</li>
                            <li><strong>Total Question:</strong> <?= count($totalQuestions) ?></li>
                            <li><strong>Date Finished:</strong> <?= $questionAnswered['fld_date_answered'] ?: 'N/A' ?></li>
                        </ul>
                        <?php foreach ($records as $record): ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <?= $config['question']['categories'][$record['fld_category']] ?>
                                </div>
                                <div class="panel-body">
                                    <div class="well">
                                        <?= $record['fld_question'] ?>
                                    </div>
                                    <?php if ($record['fld_category'] == 'sa'): ?>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <?php if ($record['fld_student_answers'][0]['fld_correct'] == 1): ?>
                                                        <i class="fa fa-check text-success"></i>
                                                    <?php else: ?>
                                                        <i class="fa fa-times text-danger"></i>
                                                    <?php endif ?>
                                                </span>
                                                <input type="text" value="<?= $record['fld_student_answers'][0]['fld_answer'] ?>" class="form-control" disabled>
                                            </div>
                                            <?php if ($record['fld_student_answers'][0]['fld_correct'] == 0): ?>
                                                <div class="helper-block">
                                                    <i class="fa fa-check text-success"></i>
                                                    <?= $record['fld_answers'][0]['fld_answer'] ?>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    <?php elseif ($record['fld_category'] == 'mc'): ?>
                                        <ul class="list-unstyled">
                                            <?php foreach ($record['fld_answers'] as $answer): ?>
                                                <?php if ($record['fld_student_answers'][0]['fld_answer'] == $answer['fld_answer']): ?>
                                                    <li>
                                                        <label><input type="radio" checked disabled> <?= $answer['fld_answer'] ?></label>
                                                        <?php if ($record['fld_student_answers'][0]['fld_correct'] == 1): ?>
                                                            <i class="fa fa-check text-success"></i>
                                                        <?php else: ?>
                                                            <i class="fa fa-times text-danger"></i>
                                                        <?php endif ?>
                                                    </li>
                                                <?php else: ?>
                                                    <li>
                                                        <label><input type="radio" disabled> <?= $answer['fld_answer'] ?></label>
                                                        <?php if ($answer['fld_correct'] == 1): ?>
                                                            <i class="fa fa-check text-success"></i>
                                                        <?php endif ?>
                                                    </li>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </ul>
                                    <?php elseif ($record['fld_category'] == 'tf'): ?>
                                        <ul class="list-unstyled">
                                            <?php if ($record['fld_student_answers'][0]['fld_answer'] == 'true'): ?>
                                                <?php if ($record['fld_student_answers'][0]['fld_correct'] == 1): ?>
                                                    <li><label><input type="radio" disabled checked> True</label> <i class="fa fa-check text-success"></i></li>
                                                    <li><label><input type="radio" disabled> False</label></li>
                                                <?php else: ?>
                                                    <li><label><input type="radio" disabled checked> True</label> <i class="fa fa-times text-danger"></i></li>
                                                    <li><label><input type="radio" disabled> False</label> <i class="fa fa-check text-success"></i></li>
                                                <?php endif ?>
                                            <?php else: ?>
                                                <?php if ($record['fld_student_answers'][0]['fld_correct'] == 1): ?>
                                                    <li><label><input type="radio" disabled> True</label></li>
                                                    <li><label><input type="radio" disabled checked> False</label> <i class="fa fa-check text-success"></i></li>
                                                <?php else: ?>
                                                    <li><label><input type="radio" disabled> True</label> <i class="fa fa-check text-success"></i></li>
                                                    <li><label><input type="radio" disabled checked> False</label> <i class="fa fa-times text-danger"></i></li>
                                                <?php endif ?>
                                            <?php endif ?>
                                        </ul>
                                    <?php elseif ($record['fld_category'] == 'fb'): ?>
                                        <?php foreach ($record['fld_student_answers'] as $answer): ?>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <?php if ($answer['fld_correct'] == 1): ?>
                                                            <i class="fa fa-check text-success"></i>
                                                        <?php else: ?>
                                                            <i class="fa fa-times text-danger"></i>
                                                        <?php endif ?>
                                                    </span>
                                                    <input type="text" class="form-control" disabled value="<?= $answer['fld_answer'] ?>">
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php elseif ($record['fld_category'] == 'mt'): ?>
                                        <?php for ($i = 0; $i < count($record['fld_answers']); $i+=2): ?>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" value="<?= $record['fld_answers'][$i]['fld_answer'] ?>" disabled>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <?php foreach ($record['fld_student_answers'] as $studentAnswer): ?>
                                                            <?php if ($studentAnswer['fld_order'] ==  $record['fld_answers'][$i]['fld_order']): ?>
                                                                <div class="input-group">
                                                                    <?php if ($studentAnswer['fld_correct'] == 1): ?>
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-check text-success"></i>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-times text-danger"></i>
                                                                            <?= $record['fld_answers'][$i]['fld_answer'] ?>
                                                                        </div>
                                                                    <?php endif ?>
                                                                    <input type="text" class="form-control" value="<?= $studentAnswer['fld_answer'] ?>" disabled>
                                                                </div>
                                                                <?php break; ?>
                                                            <?php endif ?>
                                                        <?php endforeach ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endfor ?>
                                    <?php elseif ($record['fld_category'] == 'ew'): ?>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <?php if ($record['fld_student_answers'][0]['fld_correct'] == 1): ?>
                                                        <i class="fa fa-check text-success"></i>
                                                    <?php elseif ($record['fld_student_answers'][0]['fld_correct'] == 0): ?>
                                                        <i class="fa fa-times text-danger"></i>
                                                    <?php else: ?>
                                                        <i class="fa fa-asterisk"></i>
                                                    <?php endif ?>
                                                </span>
                                                <input type="text" value="<?= $record['fld_student_answers'][0]['fld_answer'] ?>" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <?php if ($record['fld_student_answers'][0]['fld_correct'] == -1): ?>
                                            <form action="<?= $config['base'] ?>/actions/sections/section_quiz_ind_answer.php" method="post">
                                                <input type="hidden" name="section_quiz_ind_answer" value="1">
                                                <input type="hidden" name="quiz_question_id" value="<?= $record['fld_student_answers'][0]['fld_quiz_question_id'] ?>">
                                                <input type="hidden" name="section_quiz_id" value="<?= $record['fld_student_answers'][0]['fld_section_quiz_id'] ?>">
                                                <input type="hidden" name="section_student_id" value="<?= $sectionQuiz['fld_section_student_id'] ?>">
                                                <input type="hidden" name="student_answer_id" value="<?= $record['fld_student_answers'][0]['fld_section_quiz_student_answer_id'] ?>">
                                                <div class="form-group">
                                                    <button type="submit" name="correct" value="1" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Correct</button>
                                                    <button type="submit" name="correct" value="0" class="btn btn-danger"><i class="fa fa-times fa-fw"></i> Wrong</button>
                                                </div>
                                            </form>
                                        <?php endif ?>
                                    <?php endif ?>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<?php require_once 'footer.php' ?>
