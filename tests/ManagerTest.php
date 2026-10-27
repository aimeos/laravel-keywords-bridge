<?php

namespace Tests;

use Aimeos\KeywordsBridge\Contracts\Driver;
use Aimeos\KeywordsBridge\Drivers\None;
use Aimeos\KeywordsBridge\Facades\Keywords;
use Aimeos\KeywordsBridge\Keyword;
use Aimeos\KeywordsBridge\Manager;
use Aimeos\KeywordsBridge\ServiceProvider;
use Orchestra\Testbench\TestCase;


class ManagerTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }


    public function testDefault(): void
    {
        $this->assertInstanceOf(None::class, Keywords::driver());
        $this->assertSame([], Keywords::volume(['laravel cms']));
        $this->assertSame([], Keywords::related('laravel cms', 'de', 10));
    }


    public function testDriverCached(): void
    {
        $manager = $this->app->make(Manager::class);

        $this->assertSame($manager, $this->app->make(Manager::class));
        $this->assertSame($manager->driver('none'), $manager->driver('none'));
        $this->assertNotSame($manager->driver('none'), $manager->driver('none', ['key' => 'test']));
    }


    public function testDriverConfig(): void
    {
        config(['keywords-bridge.default' => 'fake', 'keywords-bridge.drivers.fake' => ['key' => 'a', 'country' => 'us']]);

        $driver = Keywords::driver(null, ['country' => 'de']);

        $this->assertInstanceOf(\Aimeos\KeywordsBridge\Drivers\Fake::class, $driver);
        $this->assertSame(['key' => 'a', 'country' => 'de'], $driver->config);
        $this->assertEquals([new Keyword('laravel cms', 10)], Keywords::volume(['laravel cms']));
    }


    public function testDriverInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Keywords::driver('..\\Foo');
    }


    public function testDriverNotFound(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Keywords::driver('unknown');
    }


    public function testDriverNoContract(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Keywords::driver('invalid');
    }


    public function testKeywordJson(): void
    {
        $this->assertSame('{"keyword":"laravel cms","volume":null}', json_encode(new Keyword('laravel cms')));
    }
}
