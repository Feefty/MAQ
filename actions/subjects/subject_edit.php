<?php
require_once '../../autoload.php';

if (Input::has('subject_edit')) {
    try {
        if (empty(Input::get('name')) || empty(Input::get('description'))) {
            throw new Exception('All fields are required.');
        }

        $sql = "SELECT * FROM tbl_subjects WHERE fld_name = ? AND fld_subject_id <> ?";
        $stmt = $DB->query($sql)->getStatement();
        $stmt->execute([Input::get('name'), Input::get('subject_id')]);

        if ($stmt->rowCount()) {
            throw new Exception('Subject is already exists!');
        }

        $stmt = $DB->query('UPDATE tbl_subjects SET fld_name = ?, fld_description = ? WHERE fld_subject_id = ?')->getStatement();
        $stmt->execute([Input::get('name'), Input::get('description'), Input::get('subject_id')]);

        $Util->setMessage('Subject updated!');
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('subject_edit.php?id='.Input::get('subject_id'));
?>
