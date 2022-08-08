<?php

namespace Dtion\Tests;

use Dtion\DtionList;
use Dtion\Dtion;
use Dtion\Exceptions\CriterionDoesntMatchException;
use Faker\Factory as Faker;
use PHPUnit\Framework\TestCase;

class DtionListTest extends TestCase
{
    protected $faker;

    public function __construct()
    {
        parent::__construct();

        $this->faker = Faker::create();
    }

    public function testInstanciateEmpty()
    {
        $list = new DtionList;

        $this->assertInstanceOf(DtionList::class, $list);
        $this->assertCount(0, $list);
    }

    public function testInstanciateWithDtion()
    {
        $list = new DtionList(new Dtion(0, 0, 0));

        $this->assertInstanceOf(DtionList::class, $list);
        $this->assertCount(1, $list);
    }

    public function testInstanciateWithArrayOfDtions()
    {
        $list = new DtionList([
            new Dtion(0, 0, 0),
            new Dtion(0, 0, 0)
        ]);

        $this->assertInstanceOf(DtionList::class, $list);
        $this->assertCount(2, $list);
    }

    public function testPushDtion()
    {
        $list = new DtionList;

        $list->push(new Dtion(0, 0, 0));
        $this->assertCount(1, $list);

        $list->push(new Dtion(0, 0, 0));
        $this->assertCount(2, $list);

        $list->push(new Dtion(0, 0, 0));
        $this->assertCount(3, $list);
    }

    public function testFindDtion()
    {
        $d1 = new Dtion(100, 200, 'd1');
        $d2 = new Dtion(201, 300, 'd2');
        $d3 = new Dtion(301, 400, 'd3');
        $d4 = new Dtion(401, 500, 'd4');
        $list = new DtionList([$d1, $d2, $d3, $d4]);

        $this->assertNull($list->find(50));
        $this->assertSame($d1->result(), $list->find(150)->result());
        $this->assertSame($d2->result(), $list->find(250)->result());
        $this->assertSame($d3->result(), $list->find(350)->result());
        $this->assertSame($d4->result(), $list->find(450)->result());
        $this->assertNull($list->find(550));
    }

    public function testResultForValidCriterion()
    {
        $d1 = new Dtion(100, 200, 'd1');
        $d2 = new Dtion(201, 300, 'd2');
        $d3 = new Dtion(301, 400, 'd3');
        $d4 = new Dtion(401, 500, 'd4');
        $list = new DtionList([$d1, $d2, $d3, $d4]);

        $this->assertSame($d1->result(), $list->resultFor(150));
        $this->assertSame($d2->result(), $list->resultFor(250));
        $this->assertSame($d3->result(), $list->resultFor(350));
        $this->assertSame($d4->result(), $list->resultFor(450));
    }

    public function testResultForInvalidCriteria()
    {
        $list = new DtionList([
            new Dtion(100, 200, 'd1'),
            new Dtion(201, 300, 'd2'),
            new Dtion(301, 400, 'd3'),
            new Dtion(401, 500, 'd4'),
        ]);

        $this->expectException(CriterionDoesntMatchException::class);
        $list->resultFor(50);

        $this->expectException(CriterionDoesntMatchException::class);
        $list->resultFor(550);
    }
}
