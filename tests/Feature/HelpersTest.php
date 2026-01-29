<?php

declare(strict_types=1);

describe('Global Helpers', function () {
    describe('rut_format', function () {
        it('formats RUT with dots and dash', function () {
            expect(rut_format('123456785'))->toBe('12.345.678-5');
        });
    });

    describe('rut_format_dash', function () {
        it('formats RUT with only dash', function () {
            expect(rut_format_dash('123456785'))->toBe('12345678-5');
        });
    });

    describe('rut_clean', function () {
        it('cleans RUT', function () {
            expect(rut_clean('12.345.678-5'))->toBe('123456785');
        });
    });

    describe('rut_validate', function () {
        it('validates correct RUT', function () {
            expect(rut_validate('12.345.678-5'))->toBeTrue();
        });

        it('rejects invalid RUT', function () {
            expect(rut_validate('12.345.678-0'))->toBeFalse();
        });
    });

    describe('rut_get_number', function () {
        it('extracts number from RUT', function () {
            expect(rut_get_number('12.345.678-5'))->toBe('12345678');
        });
    });

    describe('rut_get_verifier', function () {
        it('extracts verifier from RUT', function () {
            expect(rut_get_verifier('12.345.678-5'))->toBe('5');
        });
    });

    describe('rut_calculate_verifier', function () {
        it('calculates verifier', function () {
            expect(rut_calculate_verifier('12345678'))->toBe('5');
        });
    });
});
