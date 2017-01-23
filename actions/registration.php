<?php
require_once '../autoload.php';

if (Input::has('registration')) {
    try {
        $role = 'student';
        if (empty(Input::get('username')) || empty(Input::get('password')) || empty(Input::get('repassword'))
            || empty(Input::get('first_name')) || empty(Input::get('last_name')) || empty(Input::get('middle_name'))
            || empty(Input::get('gender'))) {
            throw new Exception('All fields with asterisk (*) are required.');
        }

        // check for the extra fields if the role of the user is student
        if (Input::get('role') == 'student') {
            if (empty(Input::get('student_id')) || empty(Input::get('year_level'))) {
                throw new Exception('All fields with asterisk (*) are required.');
            }
        }

        if (Input::get('password') != Input::get('repassword')) {
            throw new Exception('Password is not match!');
        }

        // check if the registration code is valid and make sure all necessary parameters are being considered
        $registrationCode =  $DB->fetch('SELECT * FROM tbl_registration_codes
                                    INNER JOIN tbl_sections ON tbl_sections.fld_section_id = tbl_registration_codes.fld_section_id
                                    WHERE fld_code = ? AND fld_role = ? AND fld_status <> 1', [Input::get('code'), Input::get('role')]);
        if ($registrationCode == null) {
            throw new Exception('Invalid Registration Code');
        }

        // change the status of the registration code to active
        $stmt = $DB->query('UPDATE tbl_registration_codes SET fld_status = 1 WHERE fld_registration_code_id = ?')->getStatement();
        $stmt->execute([$registrationCode['fld_registration_code_id']]);

        // create a profile for the user
        $DB->insert('tbl_profiles', ['fld_first_name', 'fld_last_name', 'fld_middle_name', 'fld_gender', 'fld_contact_no', 'fld_address', 'fld_course', 'fld_student_id', 'fld_year_level'],
                    [Input::get('first_name'), Input::get('last_name'), Input::get('middle_name'), Input::get('gender'), Input::get('contact_no'), Input::get('address'), Input::get('course'), Input::get('student_id'), Input::get('year_level')]);
        $profileId = $DB->getLastInsertedId();

        // create the user
        $DB->insert('tbl_users', ['fld_username', 'fld_password', 'fld_role', 'fld_registration_code_id', 'fld_profile_id'],
                [Input::get('username'), md5(Input::get('password')), $role, $registrationCode['fld_registration_code_id'], $profileId]);
        $userId = $DB->getLastInsertedId();

        if (Input::get('role') == 'student') {
            // add the student to his section
            $DB->insertIfNotExists('tbl_section_students', ['fld_section_id', 'fld_user_id'],
                                [$registrationCode['fld_section_id'], $userId]);
        } else if (Input::get('role') == 'teacher') {
            $DB->insertIfNotExists('tbl_section_teachers', ['fld_section_id', 'fld_user_id'],
                                [$registrationCode['fld_section_id'], $userId]);
        }

        $Util->setMessage('Success registration!');
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('registration.php');
?>
