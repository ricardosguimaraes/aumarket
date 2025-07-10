<?php

namespace Tangibledesign\Framework\Core;

use Pimple\Container;

class App
{
    protected static $instance;

    protected Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public static function getInstance(): App
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function init(): void
    {
        $serviceProviders = $this->getServiceProviders($this->container);

        foreach ($serviceProviders as $serviceProvider) {
            /* @var ServiceProvider $provider */
            $serviceProvider->initiation();
        }

        foreach ($serviceProviders as $serviceProvider) {
            /* @var ServiceProvider $provider */
            $serviceProvider->afterInitiation();
        }
    }

    private function getServiceProviders(Container $container): Collection
    {
        return tdf_collect(apply_filters('tdf/providers', []))->map(static function ($providerClass) use ($container) {
            return new $providerClass($container);
        });
    }

    /**
     * @param  string  $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->container[$key] ?? null;
    }
}