<?php

namespace Calculator;

class Calculator
{
    const RNP_CALCULATOR_TYPE = 'rnp';
    const EVAL_CALCULATOR_TYPE = 'eval';

    public static $calculatorTypes = [
        self::RNP_CALCULATOR_TYPE => RPNCalculatorType::class,
        self::EVAL_CALCULATOR_TYPE => EvalCalculatorType::class,
    ];

    /**
     * @param string $infix
     * @param string $type
     *
     * @return float
     *
     * @throws \Exception
     */
    public function calculate(string $infix, string $type): float
    {
        if (!array_key_exists($type, self::$calculatorTypes)) {
            throw new \Exception('No calculator type found: ' . $type);
        }

        $class = self::$calculatorTypes[$type];
        if (!class_exists($class)) {
            throw new \Exception('Calculator Type class "' . $class . '" not found.');
        }

        /** @var CalculatorType $calculatorType */
        $calculatorType = new $class();
        return $calculatorType->calculate($infix);
    }
}
