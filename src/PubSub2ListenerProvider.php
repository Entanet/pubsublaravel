<?php

namespace Entanet\PubSubLaravel;

use Illuminate\Support\ServiceProvider;

class PubSub2ListenerProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            PubSub2ListenerCommand::class
        ]);
    }

    public function register()
    {
        //
    }
}
