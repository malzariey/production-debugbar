<?php

namespace malzariey\ProductionDebugbar;

use Filament\Panel;
use Illuminate\Routing\Router;
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
        $route = $this->app
            ->get(Router::class);
        foreach ($route->getMiddlewareGroups() as $group => $routeGroup) {
            $route->prependMiddlewareToGroup($group, Tester::class);
        }
        $this->registerPluginMiddleware();
    }

    public function registerPluginMiddleware(): void
    {
        collect(collect(filament()?->getPanels() ?? [])
            ->toArray())
            ->each(fn ($panel) => $this->reorderCurrentPanelMiddlewareStack($panel));
    }

    protected function reorderCurrentPanelMiddlewareStack(Panel $panel): void
    {
        $middlewareStack = invade($panel)->getMiddleware();

        $middleware = Tester::class;

        $middlewareCollection = collect($middlewareStack);

        $middlewareCollection->push($middleware);


        invade($panel)->middleware = $middlewareCollection->toArray();
    }

}
