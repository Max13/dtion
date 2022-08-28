<?php

namespace Dtion;

use Carbon\CarbonInterval;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use InvalidArgumentException;
use Laravel\SerializableClosure\SerializableClosure;
use Serializable;
use Stringable;

/**
 * This class stores a condition (lower and upper boundaries) and a result.
 */
class Dtion implements Arrayable, Jsonable, Serializable, Stringable
{
    /**
     * Lower boundary
     *
     * @var string|int|float|callable|Stringable
     */
    protected $lower;

    /**
     * Upper boundary
     *
     * @var string|int|float|callable|Stringable
     */
    protected $upper;

    /**
     * Result of the condition
     *
     * @var mixed
     */
    protected $result;

    /**
     * Instanciate a Dtion with a lower boundary, upper boundary and
     * the result when the criterion is between these boundaries.
     *
     * Callables boundaries are called with the criterion as first argument,
     * but will be returned as callable for the result.
     *
     * @param  string|int|float|callable|CarbonInterval|Stringable $lower  Lower boundary
     * @param  string|int|float|callable|CarbonInterval|Stringable $upper  Upper boundary
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
            && !($lower instanceof CarbonInterval)
            && !($lower instanceof Stringable)
        ) {
            throw new InvalidArgumentException('Lower boundary can either be string, int, float, callable, instance of Dtion\Contracts\Stringable or instance of Carbon\CarbonInterval. Received: '.gettype($lower));
        }

        if (
               !is_string($upper)
            && !is_int($upper)
            && !is_float($upper)
            && !is_callable($upper)
            && !($upper instanceof CarbonInterval)
            && !($upper instanceof Stringable)
        ) {
            throw new InvalidArgumentException('Upper boundary can either be string, int, float, callable, instance of Dtion\Contracts\Stringable or instance of Carbon\CarbonInterval. Received: '.gettype($upper));
        }

        if ($lower instanceof CarbonInterval) {
            $this->lower = $lower->settings([
                'toStringFormat' => function (CarbonInterval $interval) {
                    return $interval->spec();
                },
            ]);
        } elseif ($lower instanceof Stringable) {
            $this->lower = (string) $lower;
        } else {
            $this->lower = $lower;
        }

        if ($upper instanceof CarbonInterval) {
            $this->upper = $upper->settings([
                'toStringFormat' => function (CarbonInterval $interval) {
                    return $interval->spec();
                },
            ]);
        } elseif ($upper instanceof Stringable) {
            $this->upper = (string) $upper;
        } else {
            $this->upper = $upper;
        }

        $this->result = $result;
    }

    /**
     * Static mode to instanciate a Dtion
     *
     * @see    Dtion::__construct()
     *
     * @return Dtion
     */
    public static function make($lowerBoundary, $upperBoundary, $result) : Dtion
    {
        return new self($lowerBoundary, $upperBoundary, $result);
    }

    /**
     * Return the stored result
     *
     * @return mixed
     */
    public function result()
    {
        return $this->result;
    }

    /**
     * Match a criterion with lower and upper boundaries.
     *
     * @param  mixed $criterion
     *
     * @return bool
     */
    public function match($criterion)
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
     * Normalize data if necessary, before sending to constructor
     *
     * @param  array $data
     * @return array
     */
    public static function normalize(array $data)
    {
        $serializableClosure = 'O:47:"Laravel\SerializableClosure\SerializableClosure"';

        foreach (['lower', 'upper', 'result'] as $key) {
            // Check if serialized SerializableClosure
            if (
                   is_string($data[$key])
                && substr($data[$key], 0, strlen($serializableClosure)) === $serializableClosure
            ) {
                $data[$key] = unserialize($data[$key]);
            }

            if ($data[$key] instanceof SerializableClosure) {
                $data[$key] = $data[$key]->getClosure();
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
        $data = static::normalize($data);

        return new static($data['lower'], $data['upper'], $data['result']);
    }

    /** @inheritDoc */
    public function toArray()
    {
        $data = [];

        foreach (['lower', 'upper', 'result'] as $key) {
            if (is_callable($this->{$key})) {
                $data[$key] = serialize(new SerializableClosure($this->{$key}));
            } else {
                $data[$key] = $this->{$key};
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
        return json_encode($this->toArray(), $options);
    }

    /** @inheritDoc */
    public function __serialize() : array
    {
        return $this->toArray();
    }

    /** @inheritDoc */
    public function __unserialize(array $data) : void
    {
        $data = static::normalize($data);

        $this->__construct($data['lower'], $data['upper'], $data['result']);
    }

    /** @inheritDoc */
    public function serialize() : ?string
    {
        return serialize($this->__serialize());
    }

    /** @inheritDoc */
    public function unserialize($data) : void
    {
        $this->__unserialize(unserialize($data));
    }

    /** @inheritDoc */
    public function __toString() : string
    {
        return serialize($this);
    }
}
