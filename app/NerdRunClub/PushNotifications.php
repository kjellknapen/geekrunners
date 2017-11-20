<?php
/**
 * Created by PhpStorm.
 * User: kjell
 * Date: 19.11.17
 * Time: 12:27
 */

namespace NerdRunClub;


use Pushpad\Pushpad;

class PushNotifications
{
    public function __construct()
    {
        Pushpad::$auth_token = "ae8454f48ea83d00321d73ee3f67ec9b";
        Pushpad::$project_id = 4732;
    }

}