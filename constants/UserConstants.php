<?php

namespace app\constants;


class UserConstants
{
    const SCENARIO = [
        'CHANGE_PASSWORD' => 'CHANGE_PASSWORD',
    ];

    const ROLE = [
        'GUEST' => 0,
        'ADMIN' => 1,
        'OWNER' => 2
    ];

    const RULE = [
        'ADMIN_PANEL' => 1,
        'DELETE_USER' => 2,
        'OWNER' => 3,
        'DELETE_MODEL_FULL' => 4,
        'NO_DUPLICATE' => 5,
        'DOWNLOAD_IMAGE' => 6,
    ];

}