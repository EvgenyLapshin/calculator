<?php

namespace Calculator;

class MultiplicationOperator extends AbstractOperator
{
    protected $priority = 1;
    protected $token = '*';
    protected $operandsCount = 2;
    protected $associative = parent::ASSOCIATIVE_LEFT;

    protected function doExecute(array $operands)
    {
        return $operands[0] * $operands[1];
    }
}
