<?php
require_once '../../autoload.php';

if (Input::has('launch')) {
    try {

        if (empty(Input::get('start')) || empty(Input::get('end')) || empty(Input::get('section')) || empty(Input::get('quiz'))) {
            throw new Exception('All fields are required!');
        }

        $section = $DB->fetch('SELECT COUNT(*) as fld_section_exists FROM tbl_section_quizzes WHERE fld_section_id = ? AND fld_quiz_id = ?',
                            [Input::get('section'), Input::get('quiz')]);
        if ($section['fld_section_exists'] > 0) {
            throw new Exception('This quiz has already been launched on that section!');
        }

        $DB->insert('tbl_section_quizzes', ['fld_section_id', 'fld_quiz_id', 'fld_start_on', 'fld_end_on', 'fld_status'],
                    [Input::get('section'), Input::get('quiz'), Input::get('start'), Input::get('end'), 1]);
        $sectionQuizId = $DB->getLastInsertedId();

        // Notify the students!
        $students = $DB->fetchAll('SELECT * FROM tbl_section_students
                    WHERE fld_section_id = ?', [Input::get('section')]);

        $studentsId = array_map(function($data) {
            return $data['fld_user_id'];
        }, $students);
        $DB->notify($studentsId, 'Quiz has landed!',
                    'A quiz from your section has landed and it needs to be answered.
                    The schedule starts on '. date('Y-m-D H:i:s', strtotime(Input::get('start'))) .' until '. date('Y-m-D H:i:s', strtotime(Input::get('end'))) .'.
                    <a href="'. $config['base'] .'/section_quiz_view.php?id='. $sectionQuizId .'"><strong>View Quiz</strong></a>');

        $Util->setMessage('The quiz has been launched!');
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('launch.php');
?>
