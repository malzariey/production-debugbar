# Use Debugbar in Production for performance analysis and fast debugging

[![Latest Version on Packagist](https://img.shields.io/packagist/v/malzariey/production-debugbar.svg?style=flat-square)](https://packagist.org/packages/malzariey/production-debugbar)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/malzariey/production-debugbar/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/malzariey/production-debugbar/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/malzariey/production-debugbar/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/malzariey/production-debugbar/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/malzariey/production-debugbar.svg?style=flat-square)](https://packagist.org/packages/malzariey/production-debugbar)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/Production-Debugbar.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/Production-Debugbar)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

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

https://your-production-app.com/some-route?your_configured_password

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
