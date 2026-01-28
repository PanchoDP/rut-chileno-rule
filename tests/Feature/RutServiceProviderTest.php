<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;

describe('RutServiceProvider', function () {
    it('registers the rutchileno validation rule', function () {
        $validator = Validator::make(
            ['rut' => '12.345.678-5'],
            ['rut' => 'rutchileno']
        );

        expect($validator->passes())->toBeTrue();
    });

    it('fails validation for invalid RUT', function () {
        $validator = Validator::make(
            ['rut' => '12.345.678-0'],
            ['rut' => 'rutchileno']
        );

        expect($validator->fails())->toBeTrue();
    });

    it('passes validation for null when not required', function () {
        $validator = Validator::make(
            ['rut' => null],
            ['rut' => 'nullable|rutchileno']
        );

        expect($validator->passes())->toBeTrue();
    });

    it('passes validation for empty string when not required', function () {
        $validator = Validator::make(
            ['rut' => ''],
            ['rut' => 'nullable|rutchileno']
        );

        expect($validator->passes())->toBeTrue();
    });

    it('fails validation when required and empty', function () {
        $validator = Validator::make(
            ['rut' => ''],
            ['rut' => 'required|rutchileno']
        );

        expect($validator->fails())->toBeTrue();
    });
});
