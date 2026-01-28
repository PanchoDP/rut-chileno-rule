<?php

declare(strict_types=1);

namespace Panchodp\RutChileno;

use Illuminate\Contracts\Validation\Factory as ValidatorFactory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator;

final class RutServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/lang', 'rutchileno');

        $this->publishes([
            __DIR__.'/lang' => resource_path('lang/vendor/rutchileno'),
        ], 'rutchileno-lang');

        /** @var ValidatorFactory $validator */
        $validator = $this->app->make('validator');

        $validator->extend('rutchileno', function (string $attribute, mixed $value, array $parameters, Validator $validator): bool {
            $isValid = RutValidator::validate($value);

            if (! $isValid) {
                $validator->setCustomMessages([
                    'rutchileno' => $this->getErrorMessage($attribute),
                ]);
            }

            return $isValid;
        });
    }

    private function getErrorMessage(string $attribute): string
    {
        $error = RutValidator::getLastError();

        $key = match ($error) {
            RutValidator::ERROR_NOT_STRING => 'rutchileno::validation.rutchileno_not_string',
            RutValidator::ERROR_MIN_LENGTH => 'rutchileno::validation.rutchileno_min_length',
            RutValidator::ERROR_MAX_LENGTH => 'rutchileno::validation.rutchileno_max_length',
            RutValidator::ERROR_INVALID_CHARACTERS => 'rutchileno::validation.rutchileno_invalid_characters',
            RutValidator::ERROR_INVALID_VERIFIER => 'rutchileno::validation.rutchileno_invalid_verifier',
            default => 'rutchileno::validation.rutchileno',
        };

        /** @var string $message */
        $message = __($key, ['attribute' => $attribute]);

        return $message;
    }
}
