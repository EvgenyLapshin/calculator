<?php

namespace Calculator;

class DivisionOperator extends AbstractOperator
{
    protected $priority = 1;
    protected $token = '/';
    protected $operandsCount = 2;
    protected $associative = parent::ASSOCIATIVE_LEFT;

    /**
     * @param array $operands
     *
     * @return float|int
     *
     * @throws \Exception
     */
    protected function doExecute(array $operands)
    {
        if ($operands[1] == 0) {
            throw new \InvalidArgumentException('Division by zero is not possible');
        }
        return $operands[0] / $operands[1];
    }
}
