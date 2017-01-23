<?php
require_once 'autoload.php';
$title = 'Section Quiz';

if (!Input::has('id'))
    die('Not found!');
if ($Util->getRole() != 'student') {
    die('Only student are allowed to view this page.');
}

$quiz = $DB->fetch('SELECT *, tbl_subjects.fld_name as fld_subject FROM tbl_section_quizzes
                LEFT JOIN tbl_quizzes ON tbl_quizzes.fld_quiz_id = tbl_section_quizzes.fld_quiz_id
                LEFT JOIN tbl_subjects ON tbl_subjects.fld_subject_id = tbl_quizzes.fld_subject_id
                WHERE fld_section_quiz_id = ?', [Input::get('id')]);
$sectionQuizId = $quiz['fld_section_quiz_id'];
$studentId = $_SESSION['fld_student_id'];
$studentSection = $DB->fetch('SELECT * FROM tbl_section_students WHERE fld_user_id = ? AND fld_section_id = ?',
                            [$_SESSION['fld_user_id'], $quiz['fld_section_id']]);
$quizQuestions = $DB->fetchAll('SELECT * FROM tbl_quiz_questions WHERE fld_quiz_id = ?', [$quiz['fld_quiz_id']]);

require_once 'header.php';
?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1><?= $quiz['fld_title'] ?> <small><?= $quiz['fld_subject'] ?></small></h1>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <form id="section-quiz-form" action="<?= $config['base'] ?>/actions/sections/section_quiz_answer.php" method="post">
                        <div class="question-container well"></div>
                        <div class="quiz-items">
                            <input type="hidden" name="section_quiz_id" value="<?= $quiz['fld_section_quiz_id'] ?>">
                            <input type="hidden" name="section_student_id" value="<?= $studentSection['fld_section_student_id'] ?>">
                            <input type="hidden" name="quiz_question_id">
                            <div class="answers-container"></div>
                            <button type="submit" name="section_quiz_answer" class="submit-answer btn btn-primary" onclick="return confirm('Submitting this answer is final and you will not be able to change it.')"><i class="fa fa-check fa-fw"></i> Submit Answer</button>
                            <span id="question-answered">0</span>/<span id="total-questions"><?= count($quizQuestions) ?></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<script type="text/javascript">
    function shuffle(a) {
        var j, x, i;
        for (i = a.length; i; i--) {
            j = Math.floor(Math.random() * i);
            x = a[i - 1];
            a[i - 1] = a[j];
            a[j] = x;
        }
        return a;
    }
    $(function() {
        $.get('<?= $config['base'] ?>/section_quiz_json.php?section_quiz_id=<?=$sectionQuizId ?>&student_id=<?= $studentId ?>', function(response) {
            response = JSON.parse(response);
            var totalQuestions = parseInt($('#total-questions').text());
            $('#question-answered').text(totalQuestions - response.length);

            if (response.length == 0) {
                $('.question-container').html('You have completed the quiz. View your result <a href="<?= $config['base'] ?>/section_quiz_view.php?id=<?= $sectionQuizId ?>&student_id=<?= $studentId ?>">here</a>.');
                $('.quiz-items').hide();
                return;
            }

            var questionId = Math.floor(Math.random() * response.length);
            var question = response[questionId];
            var questionMessage = question.fld_question;

            var format = '';
            switch (question.fld_category) {
                case 'mc':
                    var answers = '';
                    $.each(question.fld_answers, function(k, v) {
                        answers += `<li><label><input type="radio" name="answer" value="`+ v.fld_answer +`" required> `+ v.fld_answer +`</label></li>`;
                    });
                    format = `<div class="form-group">
                        <ul class="list-unstyled">`+ answers +`</ul>
                    </div>`;
                    break;
                case 'tf':
                    format = `<div class="form-group">
                        <ul class="list-unstyled">
                            <li><label><input type="radio" name="answer" value="true" required> True</label></li>
                            <li><label><input type="radio" name="answer" value="false" required> False</label></li>
                        </ul>
                    </div>`;
                    break;
                case 'sa':
                case 'ew':
                    format = `<div class="form-group">
                        <textarea name="answer" required class="form-control"></textarea>
                    </div>`;
                    break;
                case 'cb':
                    var answers = '';
                    $.each(question.fld_answers, function(k, v) {
                        answers += `<li><label><input type="checkbox" name="answer[]" value="`+ v.fld_answer +`"> `+ v.fld_answer +`</label></li>`;
                    });
                    format = `<div class="form-group">
                        <ul class="list-unstyled">`+ answers +`</ul>
                    </div>`;
                    break;
                case 'fb':
                    var answers = '';
                    questionMessage = questionMessage.replace(/\[(.*?)\]/g, '<input type="text" name="answer[]">');
                    break;
                case 'mt':
                    var tmpAnswers = question.fld_answers;
                    var answers = [];
                    var randomedAnswers = [];
                    var answers1 = [];
                    var answers2 = [];
                    for (var i = 0, j = 0; i < tmpAnswers.length; i+=2, j++) {
                        answers1[j] = tmpAnswers[i];
                        answers2[j] = tmpAnswers[i+1];
                    }

                    answers1 = shuffle(answers1);
                    answers2 = shuffle(answers2);

                    var answersOnly = answers2.map(function(v) {
                        return v.fld_answer;
                    });

                    var options = "";
                    $.each(answersOnly, function(k, v) {
                        options += `<option value="`+ v +`">`+ v +`</option>`;
                    });

                    for (var i = 0; i < answers1.length; i++) {
                        format += `<div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>`+ answers1[i]['fld_answer'] +`</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="answer[`+ answers1[i]['fld_order'] +`]">
                                        `+ options +`
                                        </select>
                                    </div>
                                </div>
                            </div>`;
                    }
                    break;
            }

            $('.answers-container').html(format);
            $('.question-container').html(questionMessage);
            $('#section-quiz-form [name="quiz_question_id"]').val(question.fld_quiz_question_id);
        });
    });
</script>
<?php require_once 'footer.php' ?>
