# Laravel Keywords Bridge

A unified keyword research bridge for Laravel providing a consistent API for
search volume and related keywords across Google Ads, Ahrefs and Semrush.

## Features

* Unified API for multiple keyword research services
* Average monthly search volume for a list of keywords
* Related keywords for a seed keyword including their search volume
* Worldwide data if the service supports it
* Easily extendable with new drivers

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=config
```

This creates the `./config/keywords-bridge.php` file:

```php
return [
    'default' => env('KEYWORDS_DRIVER', 'none'),

    'drivers' => [
        'google' => [
            'version' => env('GOOGLEADS_VERSION', 'v26'),
            'customer' => env('GOOGLEADS_CUSTOMER_ID'),
            'login' => env('GOOGLEADS_LOGIN_CUSTOMER_ID'),
            'token' => env('GOOGLEADS_DEVELOPER_TOKEN'),
            'client' => env('GOOGLEADS_CLIENT_ID'),
            'secret' => env('GOOGLEADS_CLIENT_SECRET'),
            'refresh' => env('GOOGLEADS_REFRESH_TOKEN'),
        ],
        'ahrefs' => [
            'key' => env('AHREFS_API_KEY'),
            'country' => env('AHREFS_COUNTRY', 'us'),
        ],
        'semrush' => [
            'key' => env('SEMRUSH_API_KEY'),
            'database' => env('SEMRUSH_DATABASE', 'us'),
        ],
    ],
];
```

Set your .env variables accordingly and configure the `KEYWORDS_DRIVER` value
using the name of the driver ("google", "ahrefs" or "semrush").

## API Usage

Import the facade:

```php
use Aimeos\KeywordsBridge\Facades\Keywords;
```

### Search Volume

```php
// default driver, worldwide if supported
$result = Keywords::volume(['laravel cms', 'headless cms']);

// specific driver and country (two letter ISO code)
$result = Keywords::driver('ahrefs')->volume(['laravel cms'], 'de');
```

### Related Keywords

```php
$result = Keywords::related('laravel cms', 'us', 100);
```

Both methods return a list of `Aimeos\KeywordsBridge\Keyword` objects:

```php
[
    new Keyword(keyword: 'laravel cms', volume: 1900),
    new Keyword(keyword: 'headless cms', volume: 14800),
    ...
]
```

`Keyword` objects are JSON serializable to `{"keyword": "...", "volume": 1900}`.
The volume is `null` if the service has no data for the keyword.

### Worldwide Data

If no country is passed, the drivers return:

| Driver  | Volume and related keywords                         |
|---------|-----------------------------------------------------|
| google  | Worldwide data                                      |
| ahrefs  | Worldwide data (`global_volume`)                    |
| semrush | Data of the configured `database` (no worldwide data) |

## Implement new Driver

For a new service (e.g. Foobar), create a new composer package, e.g.
`yourorg/laravel-keywords-foobar` with this `composer.json`:

```json
{
  "name": "yourorg/laravel-keywords-foobar",
  "description": "Foobar driver for Laravel Keywords Bridge",
  "type": "library",
  "license": "LGPL-2.1+",
  "autoload": {
    "psr-4": {
      "Aimeos\\KeywordsBridge\\Drivers\\": "src/"
    }
  },
  "require": {
    "php": "^8.2",
    "aimeos/laravel-keywords-bridge": "~1.0"
  }
}
```

Create a `./src/Foobar.php` file that fetches the data from the service:

```php
<?php

namespace Aimeos\KeywordsBridge\Drivers;

use Aimeos\KeywordsBridge\Contracts\Driver;
use Aimeos\KeywordsBridge\Keyword;

class Foobar implements Driver
{
    public function __construct(array $config = [])
    {
        // $config from ./config/keywords-bridge.php
    }

    public function volume(array $keywords, ?string $country = null): array
    {
        return [new Keyword('laravel cms', 1900), /*...*/];
    }

    public function related(string $keyword, ?string $country = null, int $limit = 50): array
    {
        return [new Keyword('laravel headless cms', 320), /*...*/];
    }
}
```

Register your driver in `config/keywords-bridge.php`:

```php
'drivers' => [
    'foobar' => [
        'key' => env('FOOBAR_KEY'),
    ]
],
```

## License

This package is released under the LGPL-2.1+ License.
