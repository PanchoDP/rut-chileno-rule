
<p align="center"><a target="_blank"> <img alt="Logo for Laravel Action" src="art/rut.webp"></a></p>

<p align="center">
<a ><img src="https://img.shields.io/badge/PHP-8.4%2B-blue" alt="Php"></a>
<a ><img src="https://img.shields.io/packagist/dt/panchodp/rut-chileno-rule?" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/panchodp/rut-chileno-rule"><img src="https://img.shields.io/packagist/v/panchodp/rut-chileno-rule.svg?" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/panchodp/rut-chileno-rule"><img src="https://img.shields.io/badge/License-MIT-green" alt="License"></a>

# RUT Validator

Regla de validación de RUT chileno para Laravel.

## Requisitos

- PHP 8.4+
- Laravel 10+

## Instalación

```bash
composer require panchodp/rut-chileno-rule
```

## Uso

```php
// En tu FormRequest o Controller
$request->validate([
    'rut' => 'required|rutchileno',
]);

// O con el facade Validator
use Illuminate\Support\Facades\Validator;

$validator = Validator::make($data, [
    'rut' => 'required|rutchileno',
]);
```

## Regla de validación

| Regla | Descripción |
|-------|-------------|
| `rutchileno` | Valida que el campo sea un RUT chileno válido |

Acepta formatos: `12.345.678-5`, `12345678-5`, `123456785`

## Errores específicos

El validador retorna mensajes específicos según el tipo de error:

| Error | Descripción |
|-------|-------------|
| `not_string` | El valor no es texto |
| `min_length` | El RUT es demasiado corto |
| `max_length` | Excede el máximo de caracteres (9) |
| `invalid_characters` | Contiene caracteres no permitidos |
| `invalid_verifier` | El dígito verificador es incorrecto |

> **Nota:** Los valores `null` y vacíos pasan la validación. Usa la regla `required` para campos obligatorios.

## Personalizar mensajes

Publica los archivos de idioma:

```bash
php artisan vendor:publish --tag=rutchileno-lang
```

O define el mensaje en `resources/lang/es/validation.php`:

```php
'rutchileno' => 'El :attribute no es un RUT chileno válido.',
```

## Testing

```bash
composer test

# Con coverage
composer test:coverage
```

## Licencia

[MIT](https://github.com/PanchoDP/rut-chileno-rule/blob/master/LICENSE.md)