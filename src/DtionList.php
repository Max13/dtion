<?php

namespace Dtion;

use Countable;
use Dtion\Exceptions\CriterionDoesntMatchException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Serializable;
use Stringable;

/**
 * This class stores a list of Dtion, allowing the user to find() the
 * corresponding Dtion (therefor the result) among multiple conditions.
 */
class DtionList implements
    Arrayable,
    Jsonable,
    Countable,
    Serializable,
    Stringable
{
    /**
     * Internal container
     *
     * @var Dtion[]
     */
    protected $container = [];

    /**
     * Construct an empty Dtion
     *
     * @param  Dtion|Dtion[]|null $dtions   One or multiple dtions to add
     *                                      to the list.
     *
     * @return void
     */
    public function __construct($dtions = null)
    {
        if (is_array($dtions)) {
            foreach ($dtions as $dtion) {
                $this->push($dtion);
            }
        } elseif ($dtions instanceof Dtion) {
            $this->push($dtions);
        }
    }

    /**
     * Static mode to instanciate a Dtion
     *
     * @see    Dtion::__construct()
     *
     * @param  Dtion|Dtion[]|null $dtions   One or multiple dtions to add
     *                                      to the list.
     *
     * @return DtionList
     */
    public static function make($dtions = null) : DtionList
    {
        return new self($dtions);
    }

    /**
     * Push a Dtion to the list.
     *
     * @param  Dtion $dtion
     *
     * @return void
     */
    public function push(Dtion $dtion) : void
    {
        $this->container[] = $dtion;
    }

    /**
     * Find the first dtion to match $critera, and returns it or null otherwise.
     *
     * @param  mixed $criterion
     *
     * @return Dtion|null
     */
    public function find($criterion) : ?Dtion
    {
        foreach ($this->container as $dtion) {
            if ($dtion->match($criterion)) {
                return $dtion;
            }
        }

        return null;
    }

    /**
     * Find the first dtion to match $critera, and returns it's result.
     *
     * @param  mixed $criterion
     *
     * @return mixed
     *
     * @throws CriterionDoesntMatchException
     */
    public function resultFor($criterion)
    {
        $dtion = $this->find($criterion);

        if (is_null($dtion)) {
            throw new CriterionDoesntMatchException;
        }

        return $dtion->result();
    }

    /**
     * Instanciate from array of arrays, given by self::toArray() method
     *
     * @param  array $data
     * @return self
     */
    public static function fromArray(array $data)
    {
        $dtionList = new static;

        foreach ($data as $dtionArray) {
            $dtionList->push(Dtion::fromArray($dtionArray));
        }

        return $dtionList;
    }

    /** @inheritDoc */
    public function toArray()
    {
        $data = [];

        foreach ($this->container as $dtion) {
            $data[] = $dtion->toArray();
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
    public function count() : int
    {
        return count($this->container);
    }

    /** @inheritDoc */
    public function __serialize() : array
    {
        return $this->container;
    }

    /** @inheritDoc */
    public function __unserialize(array $dtions)
    {
        $this->container = $dtions;
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
