<?php
require_once '../../autoload.php';

if (Input::has('quiz_edit')) {
    try {
        if (empty(Input::get('title')) || empty(Input::get('subject'))) {
            throw new Exception('All fields with asterisk (*) required.');
        }

        $stmt = $DB->query('UPDATE tbl_quizzes SET fld_title = ?, fld_subject_id = ?, fld_instruction = ? WHERE fld_quiz_id = ?')->getStatement();
        $stmt->execute([Input::get('title'), Input::get('subject'), Input::get('instruction'), Input::get('quiz_id')]);

        $Util->setMessage('Quiz updated!');
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('quiz_edit.php?id='. Input::get('quiz_id'));
?>
