<?php

namespace Innowise\ReqRes;

use Illuminate\Support\ServiceProvider;
use Innowise\ReqRes\ReqRes;

class ReqResServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ReqRes::class, function () {
            return new ReqRes();
        });
    }
}