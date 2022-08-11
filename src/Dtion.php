<?php

namespace Dtion;

use InvalidArgumentException;
use Laravel\SerializableClosure\SerializableClosure;
use Serializable;
use Stringable;

/**
 * This class stores a condition (lower and upper boundaries) and a result.
 */
class Dtion implements Serializable, Stringable
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
            throw new InvalidArgumentException('Lower boundary can either be string, int, float, callable or instance of Dtion\Contracts\Stringable. Received: '.gettype($upper));
        }

        if ($lower instanceof Stringable) {
            $this->lower = (string) $lower;
        } else {
            $this->lower = $lower;
        }

        if ($upper instanceof Stringable) {
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

    /** @inheritDoc */
    public function __serialize() : array
    {
        return [
            'lower' => is_callable($this->lower)
                        ? new SerializableClosure($this->lower) : $this->lower,
            'upper' => is_callable($this->upper)
                        ? new SerializableClosure($this->upper) : $this->upper,
            'result' => is_callable($this->result)
                        ? new SerializableClosure($this->result) : $this->result,
        ];
    }

    /** @inheritDoc */
    public function __unserialize(array $data) : void
    {
        if ($data['lower'] instanceof SerializableClosure) {
            $data['lower'] = $data['lower']->getClosure();
        }

        if ($data['upper'] instanceof SerializableClosure) {
            $data['upper'] = $data['upper']->getClosure();
        }

        if ($data['result'] instanceof SerializableClosure) {
            $data['result'] = $data['result']->getClosure();
        }

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
