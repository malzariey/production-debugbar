<?php

namespace malzariey\ProductionDebugbar;

use malzariey\ProductionDebugbar\Middleware\Tester;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
class ProductionDebugbarServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('production-debugbar')
            ->hasConfigFile();
    }
    public function bootingPackage()
    {
        $this->app->make('Illuminate\Contracts\Http\Kernel')->prependMiddleware(Tester::class);
    }

}
