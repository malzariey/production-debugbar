<?php

namespace malzariey\ProductionDebugbar;

use Illuminate\Contracts\Http\Kernel;
use malzariey\ProductionDebugbar\Middleware\Tester;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Illuminate\Routing\Router;

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
        parent::packageBooted();

        $kernel = $this->app->make(Kernel::class);

        $kernel->appendMiddlewareToGroup('web', Tester::class);

    }
}
