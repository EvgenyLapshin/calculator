<?php

namespace Calculator;

/**
 * Class EvalCalculator
 *
 * Warning! Don't use it in the production.
 *
 * @package Calculator
 */
class EvalCalculatorType implements CalculatorType
{
    /**
     * @param string $infix
     *
     * @return float
     */
    public function calculate(string $infix): float
    {
        if(preg_match('/(?:\-?\d+(?:\.?\d+)?[\+\-\*\/])+\-?\d+(?:\.?\d+)?/', $infix) !== FALSE){
            return eval('return ' . $infix . ';');
        }

        return 0;
    }
}
