<?php

namespace Dtion;

use Countable;
use Dtion\Contracts\Dtionable;
use Dtion\Exceptions\CriterionDoesntMatchException;
use InvalidArgumentException;

/**
 * This class stores a list of Dtion, allowing the user to find() the
 * corresponding Dtion (therefor the result) among multiple conditions.
 */
class DtionList implements Countable
{
    /**
     * Internal container
     *
     * @var Dtionable[]
     */
    protected $container = [];

    /**
     * Construct an empty Dtion
     *
     * @param  Dtionable[]|null $dtions One or multiple dtions
     *                                  to add to the list.
     *
     * @return void
     */
    public function __construct($dtions = null)
    {
        if (!is_null($dtions) && !is_array($dtions)) {
            throw new InvalidArgumentException('Dtion\DtionList first argument only accepts array of Dtion\Dtionable or null. Received: '.gettype($dtions));
        }

        foreach ($dtions ?? [] as $dtion) {
            $this->push($dtion);
        }
    }

    /**
     * Static mode to instanciate a Dtion
     *
     * @see    Dtion::__construct()
     *
     * @param  Dtionable[]|null $dtions One or multiple dtions
     *                                  to add to the list.
     *
     * @return DtionList
     */
    public static function make($dtions = null): DtionList
    {
        return new static($dtions);
    }

    /**
     * Push a Dtion to the list.
     *
     * @param  Dtionable $dtion
     *
     * @return void
     */
    public function push(Dtionable $dtion): void
    {
        $this->container[] = $dtion;
    }

    /**
     * Find the first dtion to match $critera, and returns it or null otherwise.
     *
     * @param  mixed $criterion
     *
     * @return Dtionable|null
     */
    public function find($criterion) : ?Dtionable
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

    /** @inheritDoc */
    public function count(): int
    {
        return count($this->container);
    }

    /**
     * This method defines a serialization-friendly arbitrary representation
     * of the object in form of an array.
     *
     * @return array
     */
    public function __serialize(): array
    {
        return $this->container;
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
    public function __unserialize(array $dtions)
    {
        $this->container = $dtions;
    }
}
