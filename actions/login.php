<?php
require_once '../autoload.php';

if (Input::has('login')) {
    try {
        if (empty(Input::get('username')) || empty(Input::get('password'))) {
            throw new Exception('Username or Password is required!');
        }

        $stmt = $DB->query('SELECT * FROM tbl_users
                        LEFT JOIN tbl_profiles ON tbl_profiles.fld_profile_id = tbl_users.fld_profile_id
                        WHERE fld_username = ? AND fld_password = ?')->getStatement();
        $stmt->execute([Input::get('username'), md5(Input::get('password'))]);

        if ($stmt->rowCount() == 0) {
            throw new Exception('You entered an invalid username or password.');
        }

        $_SESSION = $stmt->fetch();

        $stmt = $DB->query('UPDATE tbl_users SET fld_last_login = NOW() WHERE fld_username = ?')->getStatement();
        $stmt->execute([$_SESSION['fld_username']]);

        $Util->setMessage('You are now logged in!');
        
        if ($Util->getRole() =='teacher'){
        $Util->redirect('teacher_dashboard.php');
        }
        if ($Util->getRole() =='admin'){
        $Util->redirect('admin_dashboard.php');
        }
        if ($Util->getRole() =='student'){
        $Util->redirect('student_dashboard.php');
        }
    } catch (Exception $e) {
        $Util->setError($e->getMessage());
    }
}

$Util->redirect('index.php?error=login');
?>
