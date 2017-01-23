<?php
require_once '../../autoload.php';

if (Input::has('section_quiz_ind_answer')) {
    try {
        $questionId = (int) Input::get('quiz_question_id');
        $sectionQuizId = (int) Input::get('section_quiz_id');
        $sectionStudentId = (int) Input::get('section_student_id');
        $studentAnswerId = (int) Input::get('student_answer_id');
        $correct = (int) Input::get('correct');

        // update the answer
        $stmt = $DB->query('UPDATE tbl_section_quiz_student_answers SET fld_correct = ? WHERE fld_section_quiz_student_answer_id = ?')->getStatement();
        $stmt->execute([$correct, $studentAnswerId]);

        $question = $DB->fetch('SELECT * FROM tbl_quiz_questions
                                WHERE fld_quiz_question_id = ?', [$questionId]);

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
        if (count($quizQuestions) == count($questionAnswered)) {
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

$profile = $DB->fetch('SELECT * FROM tbl_section_students
            LEFT JOIN tbl_users ON tbl_users.fld_user_id = tbl_section_students.fld_user_id
            LEFT JOIN tbl_profiles ON tbl_profiles.fld_profile_id = tbl_users.fld_profile_id
            WHERE tbl_section_students.fld_section_student_id = ?',
            [$sectionStudentId]);

$Util->redirect('section_quiz_stats.php?id='. Input::get('section_quiz_id') .'&student_id='. $profile['fld_student_id']);
?>
