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
    const TYPE_MESSAGE_ERROR = 1;
    const TYPE_MESSAGE_SUCCESS = 2;

    public static function setMessage($mes, $type = 1) {
        $message = ['type' => $type];
        if (is_array($mes)) {
            $mes_shift = array_shift($mes);
            $message['message'] = $mes_shift[0];
        } else {
            $message['message'] = $mes;
        }
        $_SESSION['messages'][] = $message;

    }

    public static function getMessage() {

        if (!empty($_SESSION['messages'])) {
            $message = $_SESSION['messages'][0];
            $class = $message['type'] == self::TYPE_MESSAGE_SUCCESS ? 'success' : '';
            unset($_SESSION['messages']);
            return '<div class="flash-errors ' . $class . '"><span class="flash-errors__text">' . $message['message'] . '</span><div class="flash-errors__close">x</div></div>';
        }
    }
}