<?php
require_once '../../autoload.php';

if (Input::has('subject_create')) {
    try {
        if (empty(Input::get('name')) || empty(Input::get('description'))) {
            throw new Exception('All fields are required.');
        }

        $sql = "SELECT * FROM tbl_subjects WHERE fld_name = ?";
        $stmt = $DB->query($sql)->getStatement();
        $stmt->execute([Input::get('name')]);

        if ($stmt->rowCount()) {
            throw new Exception('Subject is already exists!');
        }

        $DB->insert('tbl_subjects', ['fld_name', 'fld_description'], [Input::get('name'), Input::get('description')]);

        $Util->setMessage('New subject has been created!');
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('subject_create.php');
?>
