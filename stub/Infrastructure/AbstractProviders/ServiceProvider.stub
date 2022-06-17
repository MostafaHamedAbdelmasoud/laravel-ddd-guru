<?php

namespace App\Infrastructure\AbstractProviders;

use MostafaHamed\DDD\Helper\NamespaceCreator;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

abstract class ServiceProvider extends LaravelServiceProvider
{
    /**
     * @var string Alias for load Translations and views
     */
    protected $alias;

    /**
     * @var bool Set if will load commands or not
     */
    protected $hasCommands = false;

    /**
     * @var bool Set if will load factories or not
     */
    protected $hasFactories = false;

    /**
     * @var bool Set if will load migrations or not
     */
    protected $hasMigrations = false;

    /**
     * @var bool Set if will load translations or not
     */
    protected $hasTranslations = false;

    /**
     * @var bool Set if will load Views or not
     */
    protected $hasViews = false;

    /**
     * @var bool Set if will load policies or not
     */
    protected $hasPolicies = false;

    /**
     * @var bool Set if will load policies or not
     */
    protected $hasObservers = false;

    /**
     * @var array List of custom Artisan commands
     */
    protected $commands = [];

    /**
     * @var array List of model factories to load
     */
    protected $factories = [];

    /**
     * @var array List of providers to load
     */
    protected $providers = [];

    /**
     * @var array List of policies to load
     */
    protected $policies = [];

    /**
     * @var array List of policies to load
     */
    protected $observers = [];

    /**
     * Boot required registering of views and translations.
     *
     * @throws \ReflectionException
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerCommands();
        $this->registerFactories();
        $this->registerMigrations();
        $this->registerTranslations();
        $this->registerViews();
        $this->registerComponentViews();
        $this->registerObservers();
    }

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        if ($this->hasPolicies && config('ddd.policies')) {
            foreach ($this->policies as $key => $value) {
                Gate::policy($key, $value);
            }
        }
    }

    /**
     * Register domain custom Artisan commands.
     */
    protected function registerCommands()
    {
        if ($this->hasCommands && config('ddd.commands')) {
            $this->commands($this->commands);
        }
    }

    /**
     * Register Model Factories.
     */
    protected function registerFactories()
    {
        if ($this->hasFactories && config('ddd.factories')) {
            Factory::guessFactoryNamesUsing(function (string $modelName) {
                return Str::beforeLast($modelName, 'Entities')."Database\Factories\\".class_basename($modelName)."Factory";
            });
        }
    }

    /**
     * Register domain migrations.
     *
     * @throws \ReflectionException
     */
    protected function registerMigrations()
    {
        if ($this->hasMigrations && config('ddd.migrations')) {
            $this->loadMigrationsFrom($this->domainPath('Database/Migrations'));
        }
    }

    /**
     * Detects the domain base path so resources can be proper loaded on child classes.
     *
     * @param string $append
     * @return string
     * @throws \ReflectionException
     */
    protected function domainPath($append = null)
    {
        $reflection = new \ReflectionClass($this);

        $realPath = realpath(dirname($reflection->getFileName()) . '/../');

        if (!$append) {
            return $realPath;
        }

        return $realPath . '/' . $append;
    }

    /**
     * Register domain translations.
     *
     * @throws \ReflectionException
     */
    protected function registerTranslations()
    {
        if ($this->hasTranslations && config('ddd.translations')) {
            $this->loadTranslationsFrom($this->domainPath('Resources/Lang'), $this->alias);
        }
    }

    /**
     * Register domain Views.
     * Use Views by $alias
     * @throws \ReflectionException
     */
    protected function registerViews()
    {
        if ($this->hasViews && config('ddd.views')) {
            $this->loadViewsFrom($this->domainPath('Resources/Views'), $this->alias);
        }
    }

    /**
     * Register domain Views.
     * Use Views by $alias
     * @throws \ReflectionException
     */
    protected function registerObservers()
    {
        if ($this->hasObservers && config('ddd.observers')) {

            foreach($this->observers as $model=>$observer){
                $model::observe($observer);
            }

            $this->loadViewsFrom($this->domainPath('Resources/Views'), $this->alias);
        }
    }

    /**
     * Register Component Views.
     */
    public function registerComponentViews()
    {
        $directory = Path::toCommon('Components');
        if(File::isDirectory($directory)){
            $directories = Path::directories('app','Common','Components');
            foreach($directories as $dir){
                $class = NamespaceCreator::Segments('App','Common','Components',$dir,'Component');
                Blade::component(Str::lower($dir), $class);
            }
            $this->loadViewsFrom(Path::toCommon('Components'),'Component');
        }

    }

    /**
     * Register Domain ServiceProviders.
     */
    public function register()
    {
        collect($this->providers)->each(function ($providerClass) {
            $this->app->register($providerClass);
        });
    }

}
