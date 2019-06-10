<?php

namespace Calculator;

class AdditionOperator extends AbstractOperator
{
    protected $priority = 0;
    protected $token = '+';
    protected $operandsCount = 2;
    protected $associative = parent::ASSOCIATIVE_LEFT;

    protected function doExecute(array $operands)
    {
        return $operands[0] + $operands[1];
    }
}
