<?php

namespace Dtion;

use Countable;
use Dtion\Exceptions\CriterionDoesntMatchException;
use Serializable;
use Stringable;

/**
 * This class stores a list of Dtion, allowing the user to find() the
 * corresponding Dtion (therefor the result) among multiple conditions.
 */
class DtionList implements Countable, Serializable, Stringable
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
