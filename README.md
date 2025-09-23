# Use Debugbar in Production for performance analysis and fast debugging

[![Latest Version on Packagist](https://img.shields.io/packagist/v/malzariey/production-debugbar.svg?style=flat-square)](https://packagist.org/packages/malzariey/production-debugbar)
[![Total Downloads](https://img.shields.io/packagist/dt/malzariey/production-debugbar.svg?style=flat-square)](https://packagist.org/packages/malzariey/production-debugbar)

This package enables the powerful Laravel Debugbar for safe and effective use in production environments. It allows developers to gain valuable insights into application performance, database queries, and request lifecycle without compromising security or negatively impacting the user experience. Utilize this tool for fast debugging and performance analysis directly on your live application.

## Installation

You can install the package via composer:

```bash
composer require malzariey/production-debugbar --dev
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="production-debugbar-config"
```

This is the contents of the published config file, showing the default query parameter and password used for enabling the Debugbar:

```php
return [
    "password" => env("PRODUCTION_DEBUGBAR_PASSWORD", "MyPassword"),
    "get_parameter" => env("PRODUCTION_DEBUGBAR_GET_PARAMETER", 'pd_debug'),
];


```
**Note**: 

Make sure to add PRODUCTION_DEBUGBAR_PASSWORD to your .env file if you want to change the password configuration.

## Usage


This package provides a middleware that automatically checks if the Laravel Debugbar should be enabled based on a request cookie. You can enable the Debugbar on any route by adding a query parameter with a specific password that matches the one configured in your `production-debugbar-config` file.

### Customizing the Query Parameter

By default, the query parameter used to enable the Debugbar is configurable via the `production-debugbar.get_parameter` config option. This allows you to choose a custom parameter name instead of using the password directly as the parameter key.

For example, if your config contains:

```php
return [
    "password" => env("PRODUCTION_DEBUGBAR_PASSWORD", "MyPassword"),
    "get_parameter" => env("PRODUCTION_DEBUGBAR_GET_PARAMETER", 'pd_debug'),
];
```

You can enable the Debugbar by visiting:

```
https://your-production-app.com/any-route?pd_debug=MyPassword
```

Replace `pd_debug` with your configured parameter name, and `MyPassword` with your configured password.

If you do not set `get_parameter`, the default parameter name will be used as defined in the package.

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
