<?php
require_once 'autoload.php';

if (Input::has('section_quiz_id') && Input::has('student_id')) {
    $sectionQuizId = Input::get('section_quiz_id');
    $studentId = Input::get('student_id');

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

    $questions = array_map(function($question) use ($DB) {
        $question = (array) $question;
        $question['fld_answers'] = $DB->fetchAll('SELECT * FROM tbl_quiz_question_answers
                                            WHERE fld_quiz_question_id = ?', [$question['fld_quiz_question_id']], PDO::FETCH_OBJ);
        return $question;
    }, $questions);

    die(json_encode($questions));
} else {
    die(json_encode(['message' => 'Not found']));
}

?>
