<?php

declare(strict_types=1);

/**
 * Class Container
 *
 * @filesource   Container.php
 * @created      14.03.2017
 * @package      Webfleet
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace Webfleet;

/**
 * A generic container with getter and setter for dynamic properties.
 */
abstract class Container
{
    /**
     * Container constructor.
     *
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties = [])
    {
        foreach ($properties as $key => $value) {
            $this->__set($key, $value);
        }
    }

    /**
     * Magic getter for properties.
     *
     * @return mixed Returns the property value or false if not found.
     */
    public function __get(string $property): mixed
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        return false;
    }

    /**
     * Magic setter for properties.
     */
    public function __set(string $property, mixed $value): void
    {
        if (property_exists($this, $property)) {
            $this->{$property} = $value;
        }
    }

    /**
     * Convert the container to an array.
     *
     * @return array<string, mixed>
     */
    public function __toArray(): array
    {
        $arr = [];

        foreach ($this as $key => $val) {
            $arr[$key] = $val;
        }

        return $arr;
    }
}
