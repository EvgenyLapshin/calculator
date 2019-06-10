<?php

use PHPUnit\Framework\TestCase;
use Calculator\OperatorFactory;
use Calculator\AdditionOperator;
use Calculator\SubtractionOperator;
use Calculator\MultiplicationOperator;
use Calculator\DivisionOperator;

/**
 * Class OperatorFactoryTest
 */
class OperatorFactoryTest extends TestCase
{
    public function additionProvider()
    {
        return [
            [AdditionOperator::class, '+'],
            [SubtractionOperator::class, '-'],
            [MultiplicationOperator::class, '*'],
            [DivisionOperator::class, '/'],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @param string $class
     * @param string $token
     *
     * @throws Exception
     */
    public function testGetOperator(string $class, string $token)
    {
        $result = OperatorFactory::getOperator($token);
        $this->assertInstanceOf($class, $result);
    }

    /**
     * @throws Exception
     */
    public function testGetOperatorWithNumber()
    {
        $token = 5;
        $result = OperatorFactory::getOperator($token);
        $this->assertEquals($result, $token);
    }
}
