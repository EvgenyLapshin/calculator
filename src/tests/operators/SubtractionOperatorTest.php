<?php

use Calculator\SubtractionOperator;
use PHPUnit\Framework\TestCase;

/**
 * Class SubtractionOperatorTest
 */
class SubtractionOperatorTest extends TestCase
{
    /**
     * @var SubtractionOperator
     */
    private $subtractionOperator;

    protected function setUp() :void
    {
        $this->subtractionOperator = new SubtractionOperator();
    }

    protected function tearDown() :void
    {
        $this->subtractionOperator = NULL;
    }

    /**
     * @throws Exception
     */
    public function testTrue()
    {
        $result = $this->subtractionOperator->execute([3, 2]);
        $this->assertEquals(1, $result);
    }

    /**
     * @throws Exception
     */
    public function testFail()
    {
        $result = $this->subtractionOperator->execute([2, 2]);
        $this->assertNotEquals(1, $result);
    }
}
