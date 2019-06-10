<?php

namespace Calculator;

/**
 * Interface Calculator
 *
 * @package Calculator
 */
interface CalculatorType
{
    /**
     * @param string $infix
     *
     * @return float
     */
    public function calculate(string $infix): float;
}
