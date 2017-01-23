<?php
require_once '../../autoload.php';

if (Input::has('room_edit')) {
    try {
        if (empty(Input::get('name')) || empty(Input::get('status'))) {
            throw new Exception('All fields are required.');
        }

        $sql = "SELECT * FROM tbl_rooms WHERE fld_name = ? AND fld_room_id <> ?";
        $stmt = $DB->query($sql)->getStatement();
        $stmt->execute([Input::get('name'), Input::get('room_id')]);

        if ($stmt->rowCount()) {
            throw new Exception('Room is already exists!');
        }

        $stmt = $DB->query('UPDATE tbl_rooms SET fld_name = ?, fld_status = ? WHERE fld_room_id = ?')->getStatement();
        $stmt->execute([Input::get('name'), Input::get('status'), Input::get('room_id')]);

        $Util->setMessage('Room updated!');
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('room_edit.php?id='. Input::get('room_id'));
?>
