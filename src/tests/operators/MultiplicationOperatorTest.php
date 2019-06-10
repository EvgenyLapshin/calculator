<?php

use Calculator\MultiplicationOperator;
use PHPUnit\Framework\TestCase;

/**
 * Class MultiplicationOperatorTest
 */
class MultiplicationOperatorTest extends TestCase
{
    /**
     * @var MultiplicationOperator
     */
    private $multiplicationOperator;

    protected function setUp() :void
    {
        $this->multiplicationOperator = new MultiplicationOperator();
    }

    protected function tearDown() :void
    {
        $this->multiplicationOperator = NULL;
    }

    /**
     * @throws Exception
     */
    public function testTrue()
    {
        $result = $this->multiplicationOperator->execute([3, 2]);
        $this->assertEquals(6, $result);
    }

    /**
     * @throws Exception
     */
    public function testFail()
    {
        $result = $this->multiplicationOperator->execute([2, 2]);
        $this->assertNotEquals(5, $result);
    }
}
