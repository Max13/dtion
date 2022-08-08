<?php

namespace Dtion\Tests\Doubles;

use Stringable as BaseStringable;

class Stringable implements BaseStringable
{
    protected $return;

    public function __construct($return = 'stringable')
    {
        $this->return = $return;
    }

    public function __toString() : string
    {
        return (string) $this->return;
    }
}
