<?php

declare(strict_types=1);

namespace Panchodp\RutChileno;

final class RutHelper
{
    public function clean(string $rut): string
    {
        $cleaned = preg_replace('/[^0-9kK]/', '', $rut);

        return $cleaned !== null ? mb_strtoupper($cleaned) : '';
    }

    public function format(string $rut): string
    {
        $cleaned = $this->clean($rut);

        if (mb_strlen($cleaned) < 2) {
            return $cleaned;
        }

        $verifier = mb_substr($cleaned, -1);
        $number = mb_substr($cleaned, 0, -1);

        $formatted = number_format((float) $number, 0, '', '.');

        return $formatted.'-'.$verifier;
    }

    public function formatWithDash(string $rut): string
    {
        $cleaned = $this->clean($rut);

        if (mb_strlen($cleaned) < 2) {
            return $cleaned;
        }

        $verifier = mb_substr($cleaned, -1);
        $number = mb_substr($cleaned, 0, -1);

        return $number.'-'.$verifier;
    }

    public function getNumber(string $rut): string
    {
        $cleaned = $this->clean($rut);

        if (mb_strlen($cleaned) < 2) {
            return '';
        }

        return mb_substr($cleaned, 0, -1);
    }

    public function getVerifier(string $rut): string
    {
        $cleaned = $this->clean($rut);

        if (mb_strlen($cleaned) < 1) {
            return '';
        }

        return mb_substr($cleaned, -1);
    }

    public function calculateVerifier(string $number): string
    {
        $cleanNumber = preg_replace('/[^0-9]/', '', $number);

        if ($cleanNumber === null || $cleanNumber === '') {
            return '';
        }

        $sum = 0;
        $multiplier = 2;

        for ($i = mb_strlen($cleanNumber) - 1; $i >= 0; $i--) {
            $sum += (int) $cleanNumber[$i] * $multiplier;
            $multiplier = $multiplier === 7 ? 2 : $multiplier + 1;
        }

        $result = 11 - ($sum % 11);

        return match ($result) {
            11 => '0',
            10 => 'K',
            default => (string) $result,
        };
    }

    public function isValid(mixed $rut): bool
    {
        return RutValidator::validate($rut);
    }

    public function getLastError(): ?string
    {
        return RutValidator::getLastError();
    }
}
