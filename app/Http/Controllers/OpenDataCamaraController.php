<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\Http;

use App\Jobs\PopulateDatabaseWithCamaraData;

class OpenDataCamaraController extends Controller
{   

    public function __construct()
    {

    }

    public function fetch()
    {
        // Call job synchronously
        // $dispatch = app(Dispatcher::class)->dispatchNow(new PopulateDatabaseWithCamaraData());

        // Queue job
        PopulateDatabaseWithCamaraData::dispatch();
        
        return 'Job Queued';
    }
}
