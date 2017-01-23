<?php
class Utils {
    private $configs;

    public function __construct($configs) {
        $this->configs = $configs;
    }

    public function isLogged() {
        return isset($_SESSION['fld_user_id']);
    }

    public function getRole() {
        if (!$this->isLogged())
            return null;
        return $_SESSION['fld_role'] ?: null;
    }

    /**
     * Redirects the user if it is not logged in
     * @return void
     */
    public function loginRequired() {
        if (!$this->isLogged()) {
            $this->setError('You need to login.');
            $this->redirect('login.php');
        }
    }

    public function redirect($path) {
        if (is_null($path))
            $path = 'index.php';
        header("location: ". $this->configs['base'].'/'.$path);
        die();
    }

    public function setMessage($message) {
        if (is_array($message))
            $_SESSION['message'] = $message;
        else
            $_SESSION['message'][] = $message;
    }

    public function setError($message) {
        if (is_array($message)) {
            $_SESSION['error'] = $message;
        } else {
            $_SESSION['error'][] = $message;
        }
    }

    public function getMessage() {
        $message = null;
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }
        return $message;
    }

    public function getError() {
        $error = null;
        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        }
        return $error;
    }

    public function printMessage() {
        $print = "";
        $message = $this->getMessage();
        if (!is_null($message)) {
            if (is_array($message) && count($message) > 0) {
                $print .= '<div class="alert alert-success">';
                foreach ($message as $msg) {
                    $print .= '<p>'. $msg .'</p>';
                }
                $print .= '</div>';
            } else if (!empty($message)) {
                $print .= '<div class="alert alert-success">
                    <p>'. $message .'</p>
                </div>';
            }
        }
        return $print;
    }

    public function printError() {
        $print = "";
        $error = $this->getError();
        if (!is_null($error)) {
            if (is_array($error) && count($error) > 0) {
                $print .= '<div class="alert alert-danger">';
                foreach ($error as $msg) {
                    $print .= '<p>'. $msg .'</p>';
                }
                $print .= '</div>';
            } else if (!empty($error)) {
                $print .= '<div class="alert alert-danger">
                    <p>'. $error .'</p>
                </div>';
            }
        }
        return $print;
    }

    public function getUnreadNotifCount($DB, $target) {
        $notifs = $DB->fetch('SELECT COUNT(*) as fld_notif_counts FROM tbl_notifications WHERE fld_user_id = ? AND fld_read = 0', [$target]);
        return $notifs['fld_notif_counts'];
    }
}
