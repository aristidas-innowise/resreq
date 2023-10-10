<?php

namespace Innowise\ReqRes\Facade;

use Illuminate\Support\Facades\Facade;
use Innowise\ReqRes\ReqRes as ReqResClient;

class ReqRes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ReqResClient::class;
    }
}