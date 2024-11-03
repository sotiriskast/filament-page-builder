<?php

namespace Sotiriskast\FilamentPageBuilder;

use Filament\Panel;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Sotiriskast\FilamentPageBuilder\Resources\LayoutResource;
use Sotiriskast\FilamentPageBuilder\Resources\PageResource;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Sotiriskast\FilamentPageBuilder\Commands\FilamentPageBuilderCommand;
use Sotiriskast\FilamentPageBuilder\Testing\TestsFilamentPageBuilder;

class FilamentPageBuilderServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filamentpagebuilder';

    public static string $viewNamespace = 'filamentpagebuilder';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('sotiriskast/filamentpagebuilder');
            })
            ->hasConfigFile()
            ->hasTranslations()
            ->hasMigration('create_filament_blog_tables');

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }
    }

    protected function getAssetPackageName(): ?string
    {
        return 'sotiriskast/filamentpagebuilder';
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            FilamentPageBuilderCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_filamentpagebuilder_table',
        ];
    }
}
