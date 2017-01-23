<?php
require_once '../../autoload.php';
$Util->loginRequired();

if (Input::has('profile_edit')) {
    try {
        if (empty(Input::get('first_name')) || empty(Input::get('last_name')) || empty(Input::get('middle_name'))
            || empty(Input::get('gender'))) {
            throw new Exception('All fields with asterisk (*) are required.');
        }

        // check for the extra fields if the role of the user is student
        if ($Util->getRole() == 'student') {
            if (empty(Input::get('student_id')) || empty(Input::get('year_level'))) {
                throw new Exception('All fields with asterisk (*) are required.');
            }
        }

        $stmt = $DB->query('UPDATE tbl_profiles
                SET fld_first_name = ?, fld_last_name = ?, fld_middle_name = ?, fld_gender = ?,
                    fld_contact_no = ?, fld_course = ?, fld_address = ?, fld_student_id = ?, fld_year_level = ? WHERE fld_profile_id = ?')->getStatement();
        $stmt->execute([Input::get('first_name'), Input::get('last_name'), Input::get('middle_name'), Input::get('gender'),
                        Input::get('contact_no'), Input::get('course'), Input::get('address'), Input::get('student_id'), Input::get('year_level'),
                        Input::get('profile_id')]);

        foreach (Input::get() as $key => $val) {
            $_SESSION['fld_'. $key] = $val;
        }
        $Util->setMessage('Profile updated!');
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('profile_edit.php');
?>
