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

    public static function getDaysMap()
    {
        return [1 => 'Пн', 2 => 'Вт', 3 => 'Ср', 4 => 'Чт', 5 => 'Пт', 6 => 'Сб', 7 => 'Вс'];
    }

    public static function getHoursMap()
    {
        return [
            '00' => '00', '01' => '01', '02' => '02',
            '03' => '03', '04' => '04', '05' => '05',
            '06' => '06', '07' => '07', '08' => '08',
            '09' => '09', '10' => '10', '11' => '11',
            '12' => '12', '13' => '13', '14' => '14',
            '15' => '15', '16' => '16', '17' => '17',
            '18' => '18', '19' => '19', '20' => '20',
            '21' => '21', '22' => '22', '23' => '23',
        ];
    }

    public static function getMinutesMap()
    {
        return [
            '00' => '00',
            '05' => '05',
            '10' => '10',
            '15' => '15',
            '20' => '20',
            '25' => '25',
            '30' => '30',
            '35' => '35',
            '40' => '40',
            '45' => '45',
            '50' => '50',
            '55' => '55',
        ];
    }

    public static function getCurrentUrl() {
        return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
}