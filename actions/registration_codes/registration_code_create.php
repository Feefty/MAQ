<?php
require_once '../../autoload.php';

if (Input::has('registration_code_create')) {
    try {
        if (empty(Input::get('amount')) || empty(Input::get('role')) || empty(Input::get('section'))) {
            throw new Exception('All fields are required.');
        }

        $registrationCodes = [];
        for ($i = 0; $i < Input::get('amount'); $i++) {
            $code = str_shuffle(substr(hash('sha512', (time() + $i). Input::get('section_id')), 0, 12));

            $registrationCodes[] = $code;
            $DB->insert('tbl_registration_codes', ['fld_code', 'fld_role', 'fld_section_id'], [$code, Input::get('role'), Input::get('section')]);
        }

        $Util->setMessage('New registration code has been created!<br>'. implode('<br>', $registrationCodes));
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('registration_code_create.php');
?>
