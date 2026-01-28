<?php

declare(strict_types=1);

namespace Panchodp\RutChileno;

final class RutValidator
{
    public const ERROR_NONE = null;

    public const ERROR_NOT_STRING = 'not_string';

    public const ERROR_MIN_LENGTH = 'min_length';

    public const ERROR_MAX_LENGTH = 'max_length';

    public const ERROR_INVALID_CHARACTERS = 'invalid_characters';

    public const ERROR_INVALID_VERIFIER = 'invalid_verifier';

    private static ?string $lastError = self::ERROR_NONE;

    public static function validate(mixed $rut): bool
    {
        self::$lastError = self::ERROR_NONE;

        if ($rut === null || $rut === '') {
            return true;
        }

        if (! is_string($rut)) {
            self::$lastError = self::ERROR_NOT_STRING;

            return false;
        }

        if (preg_match('/[^0-9kK.\-]/', $rut)) {
            self::$lastError = self::ERROR_INVALID_CHARACTERS;

            return false;
        }

        $rut = preg_replace('/[^k0-9]/i', '', $rut);

        if ($rut === null) {
            self::$lastError = self::ERROR_INVALID_CHARACTERS;

            return false;
        }

        if (mb_strlen($rut) < 2) {
            self::$lastError = self::ERROR_MIN_LENGTH;

            return false;
        }

        if (mb_strlen($rut) > 9) {
            self::$lastError = self::ERROR_MAX_LENGTH;

            return false;
        }

        $digitoVerificador = mb_substr($rut, -1);
        $numero = mb_substr($rut, 0, -1);

        if (! ctype_digit($numero)) {
            self::$lastError = self::ERROR_INVALID_CHARACTERS;

            return false;
        }

        $suma = 0;
        $multiplo = 2;

        for ($i = mb_strlen($numero) - 1; $i >= 0; $i--) {
            $suma += (int) $numero[$i] * $multiplo;
            $multiplo = $multiplo === 7 ? 2 : $multiplo + 1;
        }

        $digitoVerificadorEsperado = 11 - ($suma % 11);
        $digitoVerificadorEsperado = $digitoVerificadorEsperado === 11 ? '0' : ($digitoVerificadorEsperado === 10 ? 'K' : (string) $digitoVerificadorEsperado);

        if (mb_strtoupper($digitoVerificador) !== $digitoVerificadorEsperado) {
            self::$lastError = self::ERROR_INVALID_VERIFIER;

            return false;
        }

        return true;
    }

    public static function getLastError(): ?string
    {
        return self::$lastError;
    }
}
