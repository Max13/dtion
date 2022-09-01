<?php

namespace Dtion\Tests;

use Dtion\Dtion;
use Faker\Factory as Faker;
use PHPUnit\Framework\TestCase;

class DtionTest extends TestCase
{
    protected $faker;

    public function __construct()
    {
        parent::__construct();

        $this->faker = Faker::create();
    }

    public function testInstanciateWithStrings()
    {
        $this->assertInstanceOf(Dtion::class, new Dtion(
            $this->faker->word(),
            $this->faker->word(),
            $this->faker->word()
        ));
    }

    public function testInstanciateWithInts()
    {
        $this->assertInstanceOf(Dtion::class, new Dtion(
            $this->faker->randomNumber(),
            $this->faker->randomNumber(),
            $this->faker->randomNumber()
        ));
    }

    public function testInstanciateWithFloats()
    {
        $this->assertInstanceOf(Dtion::class, new Dtion(
            $this->faker->randomFloat(),
            $this->faker->randomFloat(),
            $this->faker->randomFloat()
        ));
    }

    public function testInstanciateWithCallables()
    {
        $this->assertInstanceOf(Dtion::class, new Dtion(
            function () { return 0; },
            function () { return 1; },
            function () { return 2; }
        ));
    }

    public function testDtionReturnsResultAsString()
    {
        $result = $this->faker->word();
        $dtion = new Dtion($this->faker->word(), $this->faker->word(), $result);

        $this->assertSame($result, $dtion->result());
    }

    public function testDtionReturnsResultAsInt()
    {
        $result = $this->faker->randomNumber();
        $dtion = new Dtion(
            $this->faker->randomNumber(),
            $this->faker->randomNumber(),
            $result
        );

        $this->assertSame($result, $dtion->result());
    }

    public function testDtionReturnsResultAsFloat()
    {
        $result = $this->faker->randomFloat();
        $dtion = new Dtion(
            $this->faker->randomFloat(),
            $this->faker->randomFloat(),
            $result
        );

        $this->assertSame($result, $dtion->result());
    }

    public function testDtionReturnsResultAsCallable()
    {
        $result = function ($criteria) { return $criteria; };
        $dtion = new Dtion($this->faker->word(), $this->faker->word(), $result);

        $this->assertSame($result, $dtion->result());
        $this->assertSame($result(1), call_user_func($dtion->result(), 1));
    }

    public function testMatchWithStrings()
    {
        $lower = 'ghi';
        $upper = 'rst';
        $criteriaTooLow = 'abc';
        $criteriaTooHigh = 'xyz';
        $criteriaOk = 'mno';
        $dtion = new Dtion($lower, $upper, null);

        $this->assertFalse($dtion->match($criteriaTooLow));
        $this->assertFalse($dtion->match($criteriaTooHigh));
        $this->assertTrue($dtion->match($criteriaOk));
    }

    public function testMatchWithInts()
    {
        $lower = 100;
        $upper = 200;
        $criteriaTooLow = 50;
        $criteriaTooHigh = 250;
        $criteriaOk = 150;
        $dtion = new Dtion($lower, $upper, null);

        $this->assertFalse($dtion->match($criteriaTooLow));
        $this->assertFalse($dtion->match($criteriaTooHigh));
        $this->assertTrue($dtion->match($criteriaOk));
    }

    public function testMatchWithFloats()
    {
        $lower = 0.1;
        $upper = 0.2;
        $criteriaTooLow = 0.05;
        $criteriaTooHigh = 0.25;
        $criteriaOk = 0.15;
        $dtion = new Dtion($lower, $upper, null);

        $this->assertFalse($dtion->match($criteriaTooLow));
        $this->assertFalse($dtion->match($criteriaTooHigh));
        $this->assertTrue($dtion->match($criteriaOk));
    }

    public function testSerializeWithStrings()
    {
        $lower = 'ghi';
        $upper = 'rst';
        $dtion = new Dtion($lower, $upper, null);
        $serialized = serialize($dtion);

        $this->assertEquals($dtion, unserialize($serialized));
    }

    public function testSerializeWithInts()
    {
        $lower = 100;
        $upper = 200;
        $dtion = new Dtion($lower, $upper, null);
        $serialized = serialize($dtion);

        $this->assertEquals($dtion, unserialize($serialized));
    }

    public function testSerializeWithFloats()
    {
        $lower = 0.1;
        $upper = 0.2;
        $dtion = new Dtion($lower, $upper, null);
        $serialized = serialize($dtion);

        $this->assertEquals($dtion, unserialize($serialized));
    }

    public function testToArrayWithStrings()
    {
        $lower = 'ghi';
        $upper = 'rst';
        $dtion = new Dtion($lower, $upper, null);
        $array = $dtion->toArray();

        $this->assertEquals($dtion, Dtion::fromArray($array));
    }

    public function testToArrayWithInts()
    {
        $lower = 100;
        $upper = 200;
        $dtion = new Dtion($lower, $upper, null);
        $array = $dtion->toArray();

        $this->assertEquals($dtion, Dtion::fromArray($array));
    }

    public function testToArrayWithFloats()
    {
        $lower = 0.1;
        $upper = 0.2;
        $dtion = new Dtion($lower, $upper, null);
        $array = $dtion->toArray();

        $this->assertEquals($dtion, Dtion::fromArray($array));
    }
}
