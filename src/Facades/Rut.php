<?php

declare(strict_types=1);

namespace Panchodp\RutChileno\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string clean(string $rut)
 * @method static string format(string $rut)
 * @method static string formatWithDash(string $rut)
 * @method static string getNumber(string $rut)
 * @method static string getVerifier(string $rut)
 * @method static string calculateVerifier(string $number)
 * @method static bool isValid(mixed $rut)
 * @method static string|null getLastError()
 *
 * @see \Panchodp\RutChileno\RutHelper
 */
final class Rut extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'rut';
    }
}
