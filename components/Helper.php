<?php
/**
 * Created by PhpStorm.
 * User: v
 * Date: 18.9.17
 * Time: 23.50
 */

namespace app\components;


class Helper
{
    public $errors = [];

    public static function setErrors($error) {
        $_SESSION['errors'][] = $error;
    }

    public static function getErrors() {
        if (!empty($_SESSION['errors'])) {
            $error = $_SESSION['errors'][0];
            unset($_SESSION['errors']);
            return '<div class="flash-errors">' . $error . '</div>';
        }
    }
}