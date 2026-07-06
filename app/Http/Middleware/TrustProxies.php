<?php

namespace App\Http\Middleware;

<<<<<<< HEAD
use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;
=======
use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware;
>>>>>>> b3b5690cdf7b7d2d6cdc35201acca0827eaaf74d

class TrustProxies extends Middleware
{
    /**
<<<<<<< HEAD
     * @var array<int, string>|string|null
=======
     * The trusted proxies for this application.
     *
     * @var array|string
>>>>>>> b3b5690cdf7b7d2d6cdc35201acca0827eaaf74d
     */
    protected $proxies;

    /**
<<<<<<< HEAD
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
=======
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
>>>>>>> b3b5690cdf7b7d2d6cdc35201acca0827eaaf74d
}
