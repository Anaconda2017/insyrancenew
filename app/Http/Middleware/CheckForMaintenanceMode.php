<?php

namespace App\Http\Middleware;

<<<<<<< HEAD
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;
=======
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;
>>>>>>> b3b5690cdf7b7d2d6cdc35201acca0827eaaf74d

class CheckForMaintenanceMode extends Middleware
{
    /**
<<<<<<< HEAD
     * @var array<int, string>
=======
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array
>>>>>>> b3b5690cdf7b7d2d6cdc35201acca0827eaaf74d
     */
    protected $except = [
        //
    ];
}
