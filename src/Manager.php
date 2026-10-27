<?php

namespace Aimeos\KeywordsBridge;

use Aimeos\KeywordsBridge\Contracts\Driver;


class Manager implements Driver
{
    /** @var array<string, Driver> */
    private array $drivers = [];


    /**
     * Returns the driver for the given name or the configured default driver.
     *
     * @param string|null $name Driver name like "google", "ahrefs" or "semrush"
     * @param array<string, mixed> $config Settings overwriting the configured ones (not cached)
     * @return Driver Driver instance
     */
    public function driver(?string $name = null, array $config = []): Driver
    {
        $name ??= (string) config('keywords-bridge.default', 'none');

        if (!$config && isset($this->drivers[$name])) {
            return $this->drivers[$name];
        }

        $class = '\\Aimeos\\KeywordsBridge\\Drivers\\' . ucfirst($name);

        if (!preg_match('/^[a-z][a-z0-9]*$/i', $name) || !class_exists($class) || !is_subclass_of($class, Driver::class)) {
            throw new \InvalidArgumentException("Driver [$name] not found");
        }

        $driver = new $class(array_replace(config('keywords-bridge.drivers.' . $name, []), $config));

        return $config ? $driver : $this->drivers[$name] = $driver;
    }


    public function volume(array $keywords, ?string $country = null): array
    {
        return $this->driver()->volume($keywords, $country);
    }


    public function related(string $keyword, ?string $country = null, int $limit = 50): array
    {
        return $this->driver()->related($keyword, $country, $limit);
    }
}
