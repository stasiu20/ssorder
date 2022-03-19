<?php

namespace common\services;

use yii\test\Fixture;

final class FixtureStore
{
    /** @var static */
    private static $_instance;

    /** @var Fixture[] */
    private $_fixtures = [];

    public static function getInstance(): FixtureStore
    {
        if (null === static::$_instance) {
            static::$_instance = new static();
        }

        return static::$_instance;
    }

    public function addFixture(Fixture $fixture): FixtureStore
    {
        $this->_fixtures[get_class($fixture)] = $fixture;
        return $this;
    }

    public function getFixtures(): array
    {
        return $this->_fixtures;
    }

    public function getFixtureByClassName(string $className): Fixture
    {
        if (!isset($this->_fixtures[$className])) {
            throw new \OutOfBoundsException(sprintf('Fixture "%s" not exists', $className));
        }
        return $this->_fixtures[$className];
    }

    /**
     * is not allowed to call from outside to prevent from creating multiple instances,
     * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
     */
    private function __construct()
    {
    }

    /**
     * prevent the instance from being cloned (which would create a second instance of it)
     */
    private function __clone()
    {
    }

    /**
     * prevent from being unserialized (which would create a second instance of it)
     */
    public function __wakeup()
    {
    }
}
