<?php

namespace App;

use Illuminate\Notifications\DatabaseNotification as BaseNotification;

class AlarmnotificationCustom extends BaseNotification
{
    protected $connection = 'alarmnotifications';
}


