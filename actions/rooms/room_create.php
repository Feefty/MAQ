<?php
require_once '../../autoload.php';

if (Input::has('room_create')) {
    try {
        if (empty(Input::get('name')) || empty(Input::get('status'))) {
            throw new Exception('All fields are required.');
        }

        $sql = "SELECT * FROM tbl_rooms WHERE fld_name = ?";
        $stmt = $DB->query($sql)->getStatement();
        $stmt->execute([Input::get('name')]);

        if ($stmt->rowCount()) {
            throw new Exception('Room is already exists!');
        }

        $DB->insert('tbl_rooms', ['fld_name', 'fld_status'], [Input::get('name'), Input::get('status')]);

        $Util->setMessage('New room has been created!');
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('room_create.php');
?>
