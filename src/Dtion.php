<?php

namespace Dtion;

use Dtion\Contracts\Dtionable;

/**
 * This class stores a condition (lower and upper boundaries) and a result.
 */
class Dtion extends Dtionable
{
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
        return $criterion >= $this->lower && $criterion <= $this->upper;
    }
}
