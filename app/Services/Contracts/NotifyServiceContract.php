<?php

namespace App\Services\Contracts;

interface NotifyServiceContract
{
    public function sendNotification ($notification, $id_accounts);
}
