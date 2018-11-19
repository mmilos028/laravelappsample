<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        /*
        putenv('DB_HOST=192.168.3.124');
        putenv('DB_PORT=5432');
        putenv('DB_DATABASE=tomboladb');
        putenv('DB_USERNAME=tombolauser');
        putenv('DB_PASSWORD=tombolauser');
        */

        $app = require __DIR__.'/../bootstrap/app.php';

        $app->loadEnvironmentFrom('.env');

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
