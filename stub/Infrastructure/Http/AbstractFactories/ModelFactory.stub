<?php

namespace App\Infrastructure\Http\AbstractFactories;

use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;

/**
 * Class ModelFactory.
 * Base Factory for usage inside domains.
 */
abstract class ModelFactory
{
    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var string
     */
    protected $model;

    /**
     * @var string $faker Generator
     */
    protected $faker;

    /**
     * BaseFactory constructor.
     */
    public function __construct()
    {
        $this->factory = app()->make(Factory::class);
        $this->faker = app()->make(Generator::class);
    }

    /**
     * Define Factory
     */
    public function define()
    {
        $this->factory->define($this->model, function () {
            return $this->fields();
        });
    }

    /*
     * Abstract Function to add factory states
     */
    abstract public function states();

    /**
     * @return array of Model fields
     * @throws /Exception
     */
    abstract public function fields();
}
