<?php
require_once '../../autoload.php';

if (Input::has('quiz_create')) {
    try {
        if (empty(Input::get('title')) || empty(Input::get('subject'))) {
            throw new Exception('All fields with asterisk (*) required.');
        }

        // create the quiz
        $DB->insert('tbl_quizzes', ['fld_title', 'fld_subject_id', 'fld_instruction', 'fld_user_id'],
                    [Input::get('title'), Input::get('subject'), Input::get('instruction'), $_SESSION['fld_user_id']]);
        $quizId = $DB->getLastInsertedId();

        // add a question for the quiz
        foreach (Input::get('questions') as $index => $question) {
            if (isset(Input::get('question_types')[$index]))
                $category = Input::get('question_types')[$index];
            else
                continue;

            $image = null;
            $video = null;

            if (isset($_FILES['images_'. $index]) && !empty($_FILES['images_'. $index]['name'])) {
                $image = time() .'_'.$_FILES['images_'. $index]['name'];
                $imageTarget = __DIR__ .'/../../uploads/image/'. basename($image);
                move_uploaded_file($_FILES['images_'. $index]['tmp_name'], $imageTarget);
            }

            if (isset($_FILES['videos_'. $index]) && !empty($_FILES['videos_'. $index]['name'])) {
                $video = time() .'_'. $_FILES['videos_'. $index]['name'];
                $videoTarget = __DIR__ .'/../../uploads/video/'. basename($video);
                move_uploaded_file($_FILES['videos_'. $index]['tmp_name'], $videoTarget);
            }

            $DB->insert('tbl_quiz_questions', ['fld_question', 'fld_category', 'fld_quiz_id', 'fld_image', 'fld_video'],
                        [$question, $category, $quizId, $image, $video]);
            $questionId = $DB->getLastInsertedId();

            if (isset(Input::get('answers')[$index]) || $category == 'fb') {

                // adding answers to the question
                switch ($category) {
                    case 'tf':
                        $tmpAnswers = $answers;
                        $answers = [];
                        $answers[] = $tmpAnswers;
                        break;
                    case 'fb':
                        $answers = [];
                        preg_match_all("/\[(.*?)\]/", $question, $matches);
                        if (isset($matches[1])) {
                            foreach($matches[1] as $key => $val) {
                                $answers[] = [$key => $val];
                            }
                        }
                        break;
                    default:
                        $answers = Input::get('answers')[$index];
                }

                $corrects = [];
                if (isset(Input::get('corrects')[$index]))
                    $corrects = Input::get('corrects')[$index];

                for ($i = 0; $i < count($answers); $i++) {
                    $correct = isset($corrects[$i]) ? $corrects[$i] : 1;

                    if (is_array($answers[$i])) {
                        foreach ($answers[$i] as $key => $val) {
                            $DB->insert('tbl_quiz_question_answers', ['fld_answer', 'fld_correct', 'fld_quiz_question_id', 'fld_order'],
                                        [$val, $correct, $questionId, $key]);
                        }
                    } else {
                        $DB->insert('tbl_quiz_question_answers', ['fld_answer', 'fld_correct', 'fld_quiz_question_id'],
                                    [$answers[$i], $correct, $questionId]);
                    }
                }
            }
        }

        $Util->setMessage('New quiz has been created!');
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('quiz_create.php');
?>
