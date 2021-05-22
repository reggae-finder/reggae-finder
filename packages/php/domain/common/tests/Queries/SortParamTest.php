<?php

namespace ReggaeFinder\Domain\Common\Tests\Queries;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Domain\Common\ValueObjects\SortParam;

class SortParamTest extends TestCase
{
    public function test_it_can_return_the_param()
    {
        $param = SortParam::create('name');

        $this->assertInstanceOf(SortParam::class, $param);
        $this->assertEquals('name', $param->getParam());
    }
}
