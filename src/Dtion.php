<?php

namespace Dtion;

use Dtion\Contracts\Dtionable;
use InvalidArgumentException;
use Laravel\SerializableClosure\SerializableClosure;
use Stringable;

/**
 * This class stores a condition (lower and upper boundaries) and a result.
 */
class Dtion extends Dtionable
{
    /**
     * Instanciate a Dtion with a lower boundary, upper boundary and
     * the result when the criterion is between these boundaries.
     *
     * Callables boundaries are called with the criterion as first argument,
     * but will be returned as callable for the result.
     *
     * @param  string|int|float|callable|Stringable $lower  Lower boundary
     * @param  string|int|float|callable|Stringable $upper  Upper boundary
     * @param  mixed                                $result
     *
     * @return void
     */
    public function __construct($lower, $upper, $result)
    {
        if (
               !is_string($lower)
            && !is_int($lower)
            && !is_float($lower)
            && !is_callable($lower)
            && !($lower instanceof Stringable)
        ) {
            throw new InvalidArgumentException('Lower boundary can either be string, int, float, callable or instance of Dtion\Contracts\Stringable. Received: '.gettype($lower));
        }

        if (
               !is_string($upper)
            && !is_int($upper)
            && !is_float($upper)
            && !is_callable($upper)
            && !($upper instanceof Stringable)
        ) {
            throw new InvalidArgumentException('Upper boundary can either be string, int, float, callable or instance of Dtion\Contracts\Stringable. Received: '.gettype($upper));
        }

        if ($lower instanceof Stringable) {
            $lower = (string) $lower;
        } else {
            $lower = $lower;
        }

        if ($upper instanceof Stringable) {
            $upper = (string) $upper;
        } else {
            $upper = $upper;
        }

        parent::__construct($lower, $upper, $result);
    }

    /**
     * Static mode to instanciate a Dtion
     *
     * @see    Dtion::__construct()
     *
     * @return Dtion
     */
    public static function make($lowerBoundary, $upperBoundary, $result): Dtion
    {
        return new self($lowerBoundary, $upperBoundary, $result);
    }

    /**
     * Match a criterion with lower and upper boundaries.
     *
     * @param  mixed $criterion
     *
     * @return bool
     */
    public function match($criterion): bool
    {
        if (is_callable($this->lower)) {
            $lower = call_user_func($this->lower, $criterion);
        } else {
            $lower = &$this->lower;
        }

        if (is_callable($this->upper)) {
            $upper = call_user_func($this->upper, $criterion);
        } else {
            $upper = &$this->upper;
        }

        if (is_callable($criterion)) {
            $criterion = call_user_func($criterion);
        }

        return $criterion >= $lower && $criterion <= $upper;
    }

    /**
     * Check if given value is a SerializableClosure
     *
     * @param  string $value
     * @return bool
     */
    protected static function isSerializedClosure(string $value)
    {
        $serializableClosure = 'O:47:"Laravel\SerializableClosure\SerializableClosure"';
        $substr = substr($value, 0, strlen($serializableClosure));

        return $substr === $serializableClosure;
    }

    /**
     * Normalize data if necessary, before sending to constructor
     *
     * @param  array $data
     * @return array
     */
    public static function normalize(array $data)
    {
        foreach (['lower', 'upper', 'result'] as $key) {
            if (is_string($data[$key]) && static::isSerializedClosure($data[$key])) {
                $data[$key] = unserialize($data[$key])->getClosure();
            }
        }

        return $data;
    }

    /**
     * Instanciate from array, given by self::toArray() method
     *
     * @param  array $data
     * @return self
     */
    public static function fromArray(array $data)
    {
        return parent::fromArray(static::normalize($data));
    }

    /**
     * Get the instance as a serializable array.
     *
     * @return array
     */
    public function toSerializableArray(): array
    {
        $data = parent::toArray();

        foreach ($data as &$val) {
            if (is_callable($val)) {
                $val = serialize(new SerializableClosure($val));
            }
        }

        return $data;
    }

    /**
     * Instanciate from JSON, given by self::toJson() method
     *
     * @param  string $data
     * @return self
     */
    public static function fromJson($data)
    {
        return static::fromArray(json_decode($data, true));
    }

    /** @inheritDoc */
    public function toJson($options = 0)
    {
        return json_encode($this->toSerializableArray(), $options);
    }

    /** @inheritDoc */
    public function __serialize(): array
    {
        return $this->toSerializableArray();
    }

    /** @inheritDoc */
    public function __unserialize(array $data): void
    {
        parent::__unserialize(static::normalize($data));
    }
}
