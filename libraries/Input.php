<?php
class Input {
    public static function get($name = null) {
        if (is_null($name)) {
            return isset($_POST) ? $_POST : $_GET;
        } else {
            return isset($_POST[$name]) ? $_POST[$name] : (isset($_GET[$name]) ? $_GET[$name] : null);
        }
    }

    public static function has($name) {
        if (!is_null($name))
            return isset($_POST[$name]) ? true : isset($_GET[$name]);
        return false;
    }
}
