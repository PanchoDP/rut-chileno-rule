<?php

declare(strict_types=1);

namespace Panchodp\RutChileno\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Panchodp\RutChileno\RutServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            RutServiceProvider::class,
        ];
    }
}
