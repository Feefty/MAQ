<?php
require_once '../../autoload.php';

if (Input::has('section_edit')) {
    try {
        if (empty(Input::get('name')) || empty(Input::get('year_level')) || empty(Input::get('course'))) {
            throw new Exception('All fields are required.');
        }

        $sql = "SELECT * FROM tbl_sections WHERE fld_name = ? AND fld_section_id <> ?";
        $stmt = $DB->query($sql)->getStatement();
        $stmt->execute([Input::get('name'), Input::get('section_id')]);

        if ($stmt->rowCount()) {
            throw new Exception('Section is already exists!');
        }

        $stmt = $DB->query('UPDATE tbl_sections SET fld_name = ?, fld_year_level = ?, fld_course = ? WHERE fld_section_id = ?')->getStatement();
        $stmt->execute([Input::get('name'), Input::get('year_level'), Input::get('course'), Input::get('section_id')]);

        $Util->setMessage('Section updated!');
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('section_edit.php?id='. Input::get('section_id'));
?>
