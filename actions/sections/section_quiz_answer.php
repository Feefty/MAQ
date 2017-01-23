<?php
require_once '../../autoload.php';

if (Input::has('section_quiz_answer')) {
    try {
        $questionId = (int) Input::get('quiz_question_id');
        $sectionQuizId = (int) Input::get('section_quiz_id');
        $sectionStudentId = (int) Input::get('section_student_id');
        $answer = Input::get('answer');
        if (is_array($answer)) {
            $correctAnswers = $DB->fetchAll('SELECT * FROM tbl_quiz_question_answers
                                    WHERE fld_quiz_question_id = ? AND fld_correct = 1
                                    ORDER BY fld_order', [$questionId]);

            $question = $DB->fetch('SELECT * FROM tbl_quiz_questions
                                    WHERE fld_quiz_question_id = ?', [$questionId]);

            if ($question) {
                switch ($question['fld_category']) {
                    case 'fb':
                        for ($i = 0; $i < count($correctAnswers); $i++) {
                            $isCorrect = 0;
                            if (strtolower($correctAnswers[$i]['fld_answer']) == strtolower(@$answer[$i])) {
                                $isCorrect = 1;
                            }
                            $DB->insert('tbl_section_quiz_student_answers',
                                    ['fld_answer', 'fld_section_quiz_id', 'fld_section_student_id', 'fld_correct', 'fld_quiz_question_id', 'fld_order'],
                                    [@$answer[$i], $sectionQuizId, $sectionStudentId, $isCorrect, $questionId, $correctAnswers[$i]['fld_order']]);
                        }
                        break;
                    case 'mt':
                        for ($i = 0, $j = 0; $i < count($correctAnswers); $i+=2, $j++) {
                            $isCorrect = 0;
                            $order = $correctAnswers[$i+1]['fld_order'];
                            if (strtolower($correctAnswers[$i+1]['fld_answer']) == strtolower(@$answer[$order])) {
                                $isCorrect = 1;
                            }
                            $DB->insert('tbl_section_quiz_student_answers',
                                    ['fld_answer', 'fld_section_quiz_id', 'fld_section_student_id', 'fld_correct', 'fld_quiz_question_id', 'fld_order'],
                                    [@$answer[$order], $sectionQuizId, $sectionStudentId, $isCorrect, $questionId, $correctAnswers[$i+1]['fld_order']]);
                        }
                        break;
                    case 'cb':
                        foreach ($answer as $ans) {
                            $tmpCorrect = -1;
                            foreach ($correctAnswers as $tmpAnswer) {
                                if ($tmpAnswer['fld_answer'] == $ans) {
                                    $tmpCorrect = 1;
                                    break;
                                }
                            }
                            $DB->insert('tbl_section_quiz_student_answers',
                                    ['fld_answer', 'fld_section_quiz_id', 'fld_section_student_id', 'fld_correct', 'fld_quiz_question_id'],
                                    [$ans, $sectionQuizId, $sectionStudentId, $tmpCorrect, $questionId]);
                        }
                        break;
                }
            }
        } else {
            $correctAnswer = $DB->fetch('SELECT COUNT(*) as fld_is_correct FROM tbl_quiz_question_answers
                                    WHERE fld_quiz_question_id = ? AND LOWER(fld_answer) = ? AND fld_correct = 1',
                        [$questionId, strtolower($answer)]);

            if ($question['fld_category'] == 'ew') {
                $correctAnswer['fld_is_correct'] = -1;
            }

            $DB->insert('tbl_section_quiz_student_answers',
                    ['fld_answer', 'fld_section_quiz_id', 'fld_section_student_id', 'fld_correct', 'fld_quiz_question_id'],
                    [$answer, $sectionQuizId, $sectionStudentId, $correctAnswer['fld_is_correct'], $questionId]);

        }
        
        $ew = $DB->fetch('SELECT COUNT(*) as fld_has_ew FROM tbl_quiz_questions
                    WHERE fld_quiz_id = ? AND fld_category = "ew"',
                    [$question['fld_quiz_id']]);

        // get the total questions from a quiz
        $quizQuestions = $DB->fetchAll('SELECT * FROM tbl_quiz_questions
                LEFT JOIN tbl_section_quizzes ON tbl_section_quizzes.fld_quiz_id = tbl_quiz_questions.fld_quiz_id
                WHERE tbl_section_quizzes.fld_section_quiz_id = ?
                GROUP BY tbl_quiz_questions.fld_quiz_question_id', [$sectionQuizId]);
        // get the total answered questions
        $questionAnswered = $DB->fetchAll('SELECT * FROM tbl_section_quiz_student_answers
                                    WHERE fld_section_quiz_id = ? AND fld_section_student_id = ? AND fld_correct <> -1
                                    GROUP BY fld_quiz_question_id', [$sectionQuizId, $sectionStudentId]);

        // summarize
        if (count($quizQuestions) == count($questionAnswered) && $ew['fld_has_ew'] == 0) {
            $quizSummary = $DB->fetch('SELECT *, COUNT(*) as fld_total_correct FROM tbl_section_quiz_student_answers
                                    WHERE fld_section_quiz_id = ? AND fld_correct = 1', [$sectionQuizId]);
            $DB->insert('tbl_section_quiz_summaries' ,
                    ['fld_total_questions', 'fld_score', 'fld_section_quiz_id', 'fld_section_student_id'],
                    [count($quizQuestions), $quizSummary['fld_total_correct'], $sectionQuizId, $sectionStudentId]);
        }

        // $Util->setMessage('Question has been answered!');
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('section_quiz.php?id='. Input::get('section_quiz_id'));
?>
