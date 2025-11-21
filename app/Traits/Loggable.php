<?php

namespace App\Traits;

use App\Models\LogActivity;

trait Loggable
{
    public function logActivity($logID, $userID, $modul, $action, $resourceID, $description)
    {

        LogActivity::create([
            'log_id' => $logID,
            'user_id' => $userID,
            'modul' => $modul,
            'action' => $action,
            'resource_id' => $resourceID,
            'description' => $description,
        ]);
    }
}
