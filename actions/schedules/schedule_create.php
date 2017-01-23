<?php
require_once '../../autoload.php';

if (Input::has('schedule_create')) {
    try {
        if (empty(Input::get('time_start')) || empty(Input::get('time_end')) || empty(Input::get('day')) || empty(Input::get('room')) || empty(Input::get('subject')) || empty(Input::get('teacher'))) {
            throw new Exception('All fields are required.');
        }

        $DB->insert('tbl_schedules',
                    ['fld_time_start', 'fld_time_end', 'fld_day', 'fld_room_id', 'fld_section_id', 'fld_subject_id', 'fld_user_id'],
                    [Input::get('time_start'), Input::get('time_end'), Input::get('day'), Input::get('room'), Input::get('section_id'), Input::get('subject'), Input::get('teacher')]);

        $Util->setMessage('New schedule has been created!');
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('section_view.php?id='. Input::get('section_id'));
?>
