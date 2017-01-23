<?php
require_once 'autoload.php';

$Util->loginRequired();

$data = [];
$sql = "SELECT *, tbl_quizzes.fld_title as fld_quiz, tbl_sections.fld_name as fld_section FROM tbl_section_quiz_summaries
        LEFT JOIN tbl_section_quizzes ON tbl_section_quizzes.fld_section_quiz_id = tbl_section_quiz_summaries.fld_section_quiz_id
        LEFT JOIN tbl_sections ON tbl_sections.fld_section_id = tbl_section_quizzes.fld_section_id
        LEFT JOIN tbl_quizzes ON tbl_quizzes.fld_quiz_id = tbl_section_quizzes.fld_quiz_id
        LEFT JOIN tbl_section_students ON tbl_section_students.fld_section_id = tbl_sections.fld_section_id
        LEFT JOIN tbl_users ON tbl_users.fld_user_id = tbl_section_students.fld_user_id
        LEFT JOIN tbl_profiles ON tbl_profiles.fld_profile_id = tbl_users.fld_profile_id";

if ($Util->getRole() == 'student') {
    $sql .= " WHERE tbl_section_students.fld_user_id = ?";
    $data[] = $_SESSION['fld_user_id'];

} else if ($Util->getRole() == 'teacher') {
    $sql .= " LEFT JOIN tbl_section_teachers ON tbl_section_teachers.fld_section_id = tbl_sections.fld_section_id
            WHERE tbl_section_teachers.fld_user_id = ?";
    $data[] = $_SESSION['fld_user_id'];
}
$sql .= " ORDER BY tbl_section_quizzes.fld_section_quiz_id";

$summaries = $DB->fetchAll($sql, $data);

require_once 'header.php' ?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Analytics</h1>
                    <ul class="breadcrumb">
                        <?php if ($Util->getRole() != 'teacher'): ?>
                            <li><a href="<?= $config['base'] ?>/reports_student.php">Reports</a></li>
                        <?php else: ?>
                            <li><a href="<?= $config['base'] ?>/reports.php">Reports</a></li>
                        <?php endif ?>
                        <li class="active">Analytics</li>
                    </ul>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Total number of different question types</h5>
                            <div class="well" id="question-category-chart" data-url="<?= $config['base'] ?>/charts/question_category.php">
                                <canvas id="question-category-canvas" width="400" height="400"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Student Gender</h5>
                            <div class="well" id="student-gender-chart" data-url="<?= $config['base'] ?>/charts/student_gender.php">
                                <canvas id="student-gender-canvas" width="400" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Total number of quiz in a subject</h5>
                            <div class="well" id="subject-quiz-chart" data-url="<?= $config['base'] ?>/charts/subject_quiz.php">
                                <canvas id="subject-quiz-canvas" width="400" height="400"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Total number of quiz created by Author</h5>
                            <div class="well" id="quiz-author-chart" data-url="<?= $config['base'] ?>/charts/quiz_author.php">
                                <canvas id="quiz-author-canvas" width="400" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<?php require_once 'footer.php' ?>
