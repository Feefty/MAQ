<?php
require_once '../../autoload.php';

if (Input::has('question_create')) {
    try {
        $quizId = (int) Input::get('quiz_id');
        // add a question for the quiz
        foreach (Input::get('questions') as $index => $question) {
            if (isset(Input::get('question_types')[$index]))
                $category = Input::get('question_types')[$index];
            else
                continue;

            $DB->insert('tbl_quiz_questions', ['fld_question', 'fld_category', 'fld_quiz_id'],
                        [$question, $category, $quizId]);
            $questionId = $DB->getLastInsertedId();

            if (isset(Input::get('answers')[$index]) || $category == 'fb') {
                $answers = Input::get('answers')[$index];

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

        $Util->setMessage('New question has been created!');
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('quiz_view.php?id='.$quizId);
?>
