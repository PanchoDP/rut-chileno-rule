<?php

declare(strict_types=1);

use Panchodp\RutChileno\RutHelper;

function helper(): RutHelper
{
    return new RutHelper;
}

describe('RutHelper', function () {
    describe('clean', function () {
        it('removes dots and dashes from RUT', function () {
            expect(helper()->clean('12.345.678-5'))->toBe('123456785');
        });

        it('removes only dots from RUT', function () {
            expect(helper()->clean('12.345.678-K'))->toBe('12345678K');
        });

        it('converts lowercase k to uppercase', function () {
            expect(helper()->clean('12.345.678-k'))->toBe('12345678K');
        });

        it('handles already clean RUT', function () {
            expect(helper()->clean('123456785'))->toBe('123456785');
        });

        it('handles empty string', function () {
            expect(helper()->clean(''))->toBe('');
        });

        it('removes spaces', function () {
            expect(helper()->clean('12 345 678-5'))->toBe('123456785');
        });
    });

    describe('format', function () {
        it('formats RUT with dots and dash', function () {
            expect(helper()->format('123456785'))->toBe('12.345.678-5');
        });

        it('formats already formatted RUT correctly', function () {
            expect(helper()->format('12.345.678-5'))->toBe('12.345.678-5');
        });

        it('formats RUT with K verifier', function () {
            expect(helper()->format('87654321K'))->toBe('87.654.321-K');
        });

        it('handles short RUT', function () {
            expect(helper()->format('12'))->toBe('1-2');
        });

        it('handles single character', function () {
            expect(helper()->format('5'))->toBe('5');
        });

        it('formats RUT without dots', function () {
            expect(helper()->format('12345678-5'))->toBe('12.345.678-5');
        });

        it('formats 8-digit RUT', function () {
            expect(helper()->format('999999999'))->toBe('99.999.999-9');
        });

        it('formats 7-digit RUT', function () {
            expect(helper()->format('1234567K'))->toBe('1.234.567-K');
        });
    });

    describe('formatWithDash', function () {
        it('formats RUT with only dash', function () {
            expect(helper()->formatWithDash('123456785'))->toBe('12345678-5');
        });

        it('converts full format to dash only', function () {
            expect(helper()->formatWithDash('12.345.678-5'))->toBe('12345678-5');
        });

        it('handles RUT with K verifier', function () {
            expect(helper()->formatWithDash('87654321K'))->toBe('87654321-K');
        });

        it('handles short RUT', function () {
            expect(helper()->formatWithDash('12'))->toBe('1-2');
        });
    });

    describe('getNumber', function () {
        it('extracts number from formatted RUT', function () {
            expect(helper()->getNumber('12.345.678-5'))->toBe('12345678');
        });

        it('extracts number from clean RUT', function () {
            expect(helper()->getNumber('123456785'))->toBe('12345678');
        });

        it('returns empty for short input', function () {
            expect(helper()->getNumber('5'))->toBe('');
        });

        it('returns empty for empty string', function () {
            expect(helper()->getNumber(''))->toBe('');
        });
    });

    describe('getVerifier', function () {
        it('extracts verifier from formatted RUT', function () {
            expect(helper()->getVerifier('12.345.678-5'))->toBe('5');
        });

        it('extracts K verifier', function () {
            expect(helper()->getVerifier('8.765.432-K'))->toBe('K');
        });

        it('extracts verifier from clean RUT', function () {
            expect(helper()->getVerifier('123456785'))->toBe('5');
        });

        it('returns empty for empty string', function () {
            expect(helper()->getVerifier(''))->toBe('');
        });
    });

    describe('calculateVerifier', function () {
        it('calculates verifier for number', function () {
            expect(helper()->calculateVerifier('12345678'))->toBe('5');
        });

        it('calculates K verifier', function () {
            expect(helper()->calculateVerifier('8765432'))->toBe('K');
        });

        it('calculates 0 verifier', function () {
            expect(helper()->calculateVerifier('18585543'))->toBe('0');
        });

        it('handles number with dots', function () {
            expect(helper()->calculateVerifier('12.345.678'))->toBe('5');
        });

        it('returns empty for empty input', function () {
            expect(helper()->calculateVerifier(''))->toBe('');
        });
    });

    describe('isValid', function () {
        it('returns true for valid RUT', function () {
            expect(helper()->isValid('12.345.678-5'))->toBeTrue();
        });

        it('returns false for invalid RUT', function () {
            expect(helper()->isValid('12.345.678-0'))->toBeFalse();
        });
    });

    describe('getLastError', function () {
        it('returns null after valid RUT', function () {
            $h = helper();
            $h->isValid('12.345.678-5');
            expect($h->getLastError())->toBeNull();
        });

        it('returns error after invalid RUT', function () {
            $h = helper();
            $h->isValid('12.345.678-0');
            expect($h->getLastError())->toBe('invalid_verifier');
        });
    });
});
