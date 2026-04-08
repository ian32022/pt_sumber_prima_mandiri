<?php

namespace App\Observers;

use App\Models\Permintaan;
use App\Models\User;
use App\Notifications\RequestNotification;

class RequestObserver
{
    public function created(Permintaan $request)
    {
       
    }
}