<?php

class TestCase extends Laravel\Lumen\Testing\TestCase
{
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
    }

    public function tearDown()
    {

        parent::tearDown();
    }

    public function setupBD()
    {
        $this->artisan('migrate:reset');
        $this->artisan('migrate');
        $this->artisan('db:seed');
    }
}
