<?php

class format {

    public function __construct($message) {

    }

    public static function red($message) {
        return '<span style="color:red">' . $message . '</span>';
    }

    public static function green($message) {
        return '<span style="color:green">' . $message . '</span>';
    }

    public static function blue($message) {
        return '<span style="color:blue">' . $message . '</span>';
    }

    public static function htmldiv($content, $class = NULL, $name = NULL, $id = NULL) {
        return '<div' . format::cssclass($class) . format::cssname($name) . format::cssid($id) . '>' . $content . '</div>';
    }

    public static function cssclass($classname) {
        if (strlen($classname) > 0)
            return ' class="' . $classname . '"';
    }

    public static function cssname($name) {
        if (strlen($name) > 0)
            return ' name="' . $name . '"';
    }

    public static function cssid($name) {
        if (strlen($name) > 0)
            return ' id="' . $name . '"';
    }


    // convvert stuff
    public static function bool2str($value) {
        if($value == 0 || $value == '0') {
            return 'nein';
        }
        if($value == 1 || $value == '1') {
            return 'ja';
        }
        return NULL;
    }
}

?>
