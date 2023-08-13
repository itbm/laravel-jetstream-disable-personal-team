<?php

namespace ITBM\DPT;

use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;

class ServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package) : void
    {
        $package->name('dpt');
        app('router')->aliasMiddleware('require-team', \ITBM\DPT\Middleware\RequireTeam::class);
    }
}
