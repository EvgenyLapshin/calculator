<?php

use Calculator\AdditionOperator;
use PHPUnit\Framework\TestCase;

/**
 * Class AdditionOperatorTest
 */
class AdditionOperatorTest extends TestCase
{
    /**
     * @var AdditionOperator
     */
    private $additionOperator;

    protected function setUp() :void
    {
        $this->additionOperator = new AdditionOperator();
    }

    protected function tearDown() :void
    {
        $this->additionOperator = NULL;
    }

    /**
     * @throws Exception
     */
    public function testTrue()
    {
        $result = $this->additionOperator->execute([1, 2]);
        $this->assertEquals(3, $result);
    }

    /**
     * @throws Exception
     */
    public function testFail()
    {
        $result = $this->additionOperator->execute([2, 2]);
        $this->assertNotEquals(3, $result);
    }
}
