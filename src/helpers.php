<?php

declare(strict_types=1);

use Panchodp\RutChileno\Facades\Rut;

if (! function_exists('rut_format')) {
    function rut_format(string $rut): string
    {
        return Rut::format($rut);
    }
}

if (! function_exists('rut_format_dash')) {
    function rut_format_dash(string $rut): string
    {
        return Rut::formatWithDash($rut);
    }
}

if (! function_exists('rut_clean')) {
    function rut_clean(string $rut): string
    {
        return Rut::clean($rut);
    }
}

if (! function_exists('rut_validate')) {
    function rut_validate(mixed $rut): bool
    {
        return Rut::isValid($rut);
    }
}

if (! function_exists('rut_get_number')) {
    function rut_get_number(string $rut): string
    {
        return Rut::getNumber($rut);
    }
}

if (! function_exists('rut_get_verifier')) {
    function rut_get_verifier(string $rut): string
    {
        return Rut::getVerifier($rut);
    }
}

if (! function_exists('rut_calculate_verifier')) {
    function rut_calculate_verifier(string $number): string
    {
        return Rut::calculateVerifier($number);
    }
}
