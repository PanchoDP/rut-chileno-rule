<?php

declare(strict_types=1);

use Panchodp\RutChileno\RutValidator;

describe('validate', function () {
    it('validates a correct RUT with format', function () {
        expect(RutValidator::validate('12.345.678-5'))->toBeTrue();
    });

    it('validates a correct RUT without format', function () {
        expect(RutValidator::validate('123456785'))->toBeTrue();
    });

    it('validates a RUT with K as verifier', function () {
        expect(RutValidator::validate('8.765.432-K'))->toBeTrue();
    });

    it('validates a RUT with lowercase k as verifier', function () {
        expect(RutValidator::validate('8.765.432-k'))->toBeTrue();
    });

    it('validates RUT with verifier 0', function () {
        expect(RutValidator::validate('18.585.543-0'))->toBeTrue();
    });

    it('rejects a RUT that exceeds maximum length', function () {
        expect(RutValidator::validate('123.456.789.012-3'))->toBeFalse();
        expect(RutValidator::getLastError())->toBe(RutValidator::ERROR_MAX_LENGTH);
    });

    it('rejects a RUT with 10 digits without format', function () {
        expect(RutValidator::validate('1234567890'))->toBeFalse();
        expect(RutValidator::getLastError())->toBe(RutValidator::ERROR_MAX_LENGTH);
    });

    it('accepts a RUT with maximum valid length', function () {
        expect(RutValidator::validate('99.999.999-9'))->toBeTrue();
        expect(RutValidator::getLastError())->toBeNull();
    });

    it('returns invalid verifier error for incorrect verifier', function () {
        expect(RutValidator::validate('12.345.678-0'))->toBeFalse();
        expect(RutValidator::getLastError())->toBe(RutValidator::ERROR_INVALID_VERIFIER);
    });

    it('returns not string error for non-string values', function () {
        expect(RutValidator::validate(12345678))->toBeFalse();
        expect(RutValidator::getLastError())->toBe(RutValidator::ERROR_NOT_STRING);

        expect(RutValidator::validate(['12.345.678-5']))->toBeFalse();
        expect(RutValidator::getLastError())->toBe(RutValidator::ERROR_NOT_STRING);
    });

    it('passes validation for null or empty string (use required rule for mandatory fields)', function () {
        expect(RutValidator::validate(null))->toBeTrue();
        expect(RutValidator::getLastError())->toBeNull();

        expect(RutValidator::validate(''))->toBeTrue();
        expect(RutValidator::getLastError())->toBeNull();
    });

    it('returns min length error for single character', function () {
        expect(RutValidator::validate('5'))->toBeFalse();
        expect(RutValidator::getLastError())->toBe(RutValidator::ERROR_MIN_LENGTH);
    });

    it('returns invalid characters error for RUT with letters in body', function () {
        expect(RutValidator::validate('12.3A5.678-5'))->toBeFalse();
        expect(RutValidator::getLastError())->toBe(RutValidator::ERROR_INVALID_CHARACTERS);
    });

    it('returns no error for valid RUT', function () {
        expect(RutValidator::validate('12.345.678-5'))->toBeTrue();
        expect(RutValidator::getLastError())->toBeNull();
    });
});
