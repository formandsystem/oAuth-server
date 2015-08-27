<?php

class TestCase extends Laravel\Lumen\Testing\TestCase
{
    protected static $dbInit = false;
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function setUp()
    {
        parent::setUp();

        $this->refreshApplication();

        if (!static::$dbInit) {
            static::$dbInit = true;
            $this->setupDB();
        }
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function setupDB()
    {
        $this->artisan('migrate:reset');
        $this->artisan('migrate');
        $this->artisan('db:seed');
    }
}
