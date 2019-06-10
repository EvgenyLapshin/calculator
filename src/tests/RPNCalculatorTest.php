<?php

use Calculator\RPNCalculatorType;
use PHPUnit\Framework\TestCase;

/**
 * Class CalculatorTest
 */
class RPNCalculatorTest extends TestCase
{
    /**
     * @var RPNCalculatorType
     */
    private $calculator;

    protected function setUp(): void
    {
        $this->calculator = new RPNCalculatorType();
    }

    protected function tearDown(): void
    {
        $this->calculator = NULL;
    }

    /**
     * @return array
     */
    public function additionProvider(): array
    {
        return [
            ['2 + 3', 5],
            ['4 - 3', 1],
            ['2 + (-3)', -1],
            ['4 * 5', 20],
            ['6/4', 1.5],
            ['1.2 + 1/2', 1.7],
            [' - 3/ 3 ', -1],
            ['0.5 + 0.2', 0.7],
            ['(22.43 - 45) + 2 * 3', -16.57],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @param string $infix
     * @param float $result
     *
     * @throws Exception
     */
    public function testTrue(string $infix, float $result): void
    {
        $this->assertEquals($result, $this->calculator->calculate($infix));
    }

    /**
     * @throws Exception
     */
    public function testDivisionByZeroThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculator->calculate('6/0');
    }
}
