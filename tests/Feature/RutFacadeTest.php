<?php

declare(strict_types=1);

use Panchodp\RutChileno\Facades\Rut;

describe('Rut Facade', function () {
    it('cleans RUT via facade', function () {
        expect(Rut::clean('12.345.678-5'))->toBe('123456785');
    });

    it('formats RUT via facade', function () {
        expect(Rut::format('123456785'))->toBe('12.345.678-5');
    });

    it('formats RUT with dash via facade', function () {
        expect(Rut::formatWithDash('123456785'))->toBe('12345678-5');
    });

    it('gets number via facade', function () {
        expect(Rut::getNumber('12.345.678-5'))->toBe('12345678');
    });

    it('gets verifier via facade', function () {
        expect(Rut::getVerifier('12.345.678-5'))->toBe('5');
    });

    it('calculates verifier via facade', function () {
        expect(Rut::calculateVerifier('12345678'))->toBe('5');
    });

    it('validates RUT via facade', function () {
        expect(Rut::isValid('12.345.678-5'))->toBeTrue();
        expect(Rut::isValid('12.345.678-0'))->toBeFalse();
    });

    it('gets last error via facade', function () {
        Rut::isValid('12.345.678-0');
        expect(Rut::getLastError())->toBe('invalid_verifier');
    });
});
