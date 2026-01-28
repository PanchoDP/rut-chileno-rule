<?php

declare(strict_types=1);

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

describe('Spanish validation messages', function () {
    beforeEach(function () {
        App::setLocale('es');
    });

    it('shows error for invalid verifier', function () {
        $validator = Validator::make(
            ['rut' => '12.345.678-0'],
            ['rut' => 'rutchileno']
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('rut'))->toBe('El dígito verificador del rut no es válido.');
    });

    it('shows error for max length exceeded', function () {
        $validator = Validator::make(
            ['rut' => '123.456.789.012-3'],
            ['rut' => 'rutchileno']
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('rut'))->toBe('El rut excede el máximo de caracteres permitidos.');
    });

    it('shows error for min length', function () {
        $validator = Validator::make(
            ['rut' => '5'],
            ['rut' => 'rutchileno']
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('rut'))->toBe('El rut es demasiado corto.');
    });

    it('shows error for invalid characters', function () {
        $validator = Validator::make(
            ['rut' => '12.3A5.678-5'],
            ['rut' => 'rutchileno']
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('rut'))->toBe('El rut contiene caracteres inválidos.');
    });

    it('shows error for non-string value', function () {
        $validator = Validator::make(
            ['rut' => 12345678],
            ['rut' => 'rutchileno']
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('rut'))->toBe('El rut debe ser texto.');
    });
});

describe('English validation messages', function () {
    beforeEach(function () {
        App::setLocale('en');
    });

    it('shows error for invalid verifier', function () {
        $validator = Validator::make(
            ['rut' => '12.345.678-0'],
            ['rut' => 'rutchileno']
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('rut'))->toBe('The rut has an invalid check digit.');
    });

    it('shows error for max length exceeded', function () {
        $validator = Validator::make(
            ['rut' => '123.456.789.012-3'],
            ['rut' => 'rutchileno']
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('rut'))->toBe('The rut exceeds the maximum allowed characters.');
    });

    it('shows error for min length', function () {
        $validator = Validator::make(
            ['rut' => '5'],
            ['rut' => 'rutchileno']
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('rut'))->toBe('The rut is too short.');
    });

    it('shows error for invalid characters', function () {
        $validator = Validator::make(
            ['rut' => '12.3A5.678-5'],
            ['rut' => 'rutchileno']
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('rut'))->toBe('The rut contains invalid characters.');
    });

    it('shows error for non-string value', function () {
        $validator = Validator::make(
            ['rut' => 12345678],
            ['rut' => 'rutchileno']
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('rut'))->toBe('The rut must be a string.');
    });
});
