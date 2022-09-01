<?php

namespace Dtion\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Stringable;

/**
 * This class stores the simplest form of a a condition
 * (lower and upper boundaries) and a result.
 */
abstract class Dtionable implements Arrayable, Jsonable, Stringable
{
    /**
     * Lower boundary
     *
     * @var mixed
     */
    protected $lower;

    /**
     * Upper boundary
     *
     * @var mixed
     */
    protected $upper;

    /**
     * Result of the condition
     *
     * @var mixed
     */
    protected $result;

    /**
     * Instanciate a Dtionable with a lower boundary, upper boundary and
     * the result when the criterion is between these boundaries.
     *
     * @param  mixed $lower  Lower boundary
     * @param  mixed $upper  Upper boundary
     * @param  mixed $result
     *
     * @return void
     */
    public function __construct($lower, $upper, $result)
    {
        $this->lower = $lower;
        $this->upper = $upper;
        $this->result = $result;
    }

    /**
     * Match a criterion with lower and upper boundaries.
     *
     * @param  mixed $criterion
     *
     * @return bool
     */
    abstract public function match($criterion): bool;

    /**
     * Return the stored result
     *
     * @return mixed
     */
    public function result()
    {
        return $this->result;
    }

    /** @inheritDoc */
    public static function fromArray(array $data)
    {
        return new static($data['lower'], $data['upper'], $data['result']);
    }

    /** @inheritDoc */
    public function toArray()
    {
        return [
            'lower' => $this->lower,
            'upper' => $this->upper,
            'result' => $this->result,
        ];
    }

    /** @inheritDoc */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * This method defines a serialization-friendly arbitrary representation
     * of the object in form of an array.
     *
     * @return array
     */
    public function __serialize(): array
    {
        return $this->toArray();
    }

    /**
     * This method is passed the restored array that was returned
     * from __serialize(). It may then restore the properties of the
     * object from that array as appropriate.
     *
     * @param  array $data
     *
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->__construct($data['lower'], $data['upper'], $data['result']);
    }

    /** @return string  */
    public function __toString()
    {
        return serialize($this);
    }
}
