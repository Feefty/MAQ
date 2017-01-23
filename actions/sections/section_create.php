<?php
require_once '../../autoload.php';

if (Input::has('section_create')) {
    try {
        if (empty(Input::get('name')) || empty(Input::get('year_level')) || empty(Input::get('course'))) {
            throw new Exception('All fields are required.');
        }

        $sql = "SELECT * FROM tbl_sections WHERE fld_name = ?";
        $stmt = $DB->query($sql)->getStatement();
        $stmt->execute([Input::get('name')]);

        if ($stmt->rowCount()) {
            throw new Exception('Section is already exists!');
        }

        $DB->insert('tbl_sections', ['fld_name', 'fld_year_level', 'fld_course'], [Input::get('name'), Input::get('year_level'), Input::get('course')]);

        $Util->setMessage('New section has been created!');
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('section_create.php');
?>
