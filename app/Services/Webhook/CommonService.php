<?php

namespace App\Services\Webhook;

use Illuminate\Support\Facades\Log;

class CommonService {

    protected $log;

    public function __construct()
    {
        $this->log = Log::channel('webhook_lead');
    }
}
