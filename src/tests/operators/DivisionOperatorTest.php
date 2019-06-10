<?php

use Calculator\DivisionOperator;
use PHPUnit\Framework\TestCase;

/**
 * Class DivisionOperatorTest
 */
class DivisionOperatorTest extends TestCase
{
    /**
     * @var DivisionOperator
     */
    private $divisionOperator;

    protected function setUp() :void
    {
        $this->divisionOperator = new DivisionOperator();
    }

    protected function tearDown() :void
    {
        $this->divisionOperator = NULL;
    }

    /**
     * @throws Exception
     */
    public function testTrue()
    {
        $result = $this->divisionOperator->execute([6, 3]);
        $this->assertEquals(2, $result);
    }

    /**
     * @throws Exception
     */
    public function testFail()
    {
        $result = $this->divisionOperator->execute([2, 2]);
        $this->assertNotEquals(2, $result);
    }

    /**
     * @throws Exception
     */
    public function testDivisionByZeroThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->divisionOperator->execute([6, 0]);
    }
}
