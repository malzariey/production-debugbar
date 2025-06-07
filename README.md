# Use Debugbar in Production for performance analysis and fast debugging

[![Latest Version on Packagist](https://img.shields.io/packagist/v/malzariey/production-debugbar.svg?style=flat-square)](https://packagist.org/packages/malzariey/production-debugbar)
[![Total Downloads](https://img.shields.io/packagist/dt/malzariey/production-debugbar.svg?style=flat-square)](https://packagist.org/packages/malzariey/production-debugbar)

This package enables the powerful Laravel Debugbar for safe and effective use in production environments. It allows developers to gain valuable insights into application performance, database queries, and request lifecycle without compromising security or negatively impacting the user experience. Utilize this tool for fast debugging and performance analysis directly on your live application.

## Installation

You can install the package via composer:

```bash
composer require malzariey/production-debugbar
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="production-debugbar-config"
```

This is the contents of the published config file with the default password used to enable the debugbar:

```php
return [
    "password" => env("PRODUCTION_DEBUGBAR_PASSWORD", "MyPassword"),
];


```
**Note**: 

Make sure to add PRODUCTION_DEBUGBAR_PASSWORD to your .env file if you want to change the password configuration.

## Usage
To enable and utilize the Production Debugbar, add the following line to the boot method of your AppServiceProvider.php file as the first line:



```php
<?php

namespace App\Providers;

use malzariey\ProductionDebugbar\ProductionDebugbar; // Add this use statement

class AppServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        ProductionDebugbar::check(); // Add this line

        // ... rest of your boot method
    }
}
```

This check() method handles the logic for whether Laravel DebugBar should be active. In a production environment, you can enable the Debugbar on any route by adding a query parameter with a specific password that matches the one configured in your production-debugbar-config file. For example:

https://your-production-app.com/any-route?your_configured_password

Replace your_configured_password with the actual password set in your configuration.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Majid Al Zariey](https://github.com/malzariey)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
