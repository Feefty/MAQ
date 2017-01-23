<?php
require_once '../../autoload.php';
$Util->loginRequired();

if (Input::has('password_settings')) {
    try {
        if (empty(Input::get('password')) || empty(Input::get('npassword')) || empty(Input::get('renpassword'))) {
            throw new Exception('All fields with asterisk (*) are required.');
        }

        if (Input::get('npassword') != Input::get('renpassword')) {
            throw new Exception('New password doesn\'t match with the Re-enter New Password.');
        }

        $user = $DB->fetch("SELECT COUNT(*) as fld_user_exists FROM tbl_users WHERE fld_user_id = ? AND fld_password = ?", [Input::get('user_id'), md5(Input::get('password'))]);
        if (!$user['fld_user_exists']) {
            throw new Exception('Confirm Password is incorrect!');
        }

        $stmt = $DB->query('UPDATE tbl_users SET fld_password = ? WHERE fld_user_id =?')->getStatement();
        $stmt->execute([md5(Input::get('npassword')), Input::get('user_id')]);

        foreach (Input::get() as $key => $val) {
            $_SESSION['fld_'. $key] = $val;
        }
        $Util->setMessage('Password settings updated!');
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('password_settings.php');
?>
