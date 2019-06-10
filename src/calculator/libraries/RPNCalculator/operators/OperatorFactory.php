<?php

namespace Calculator;

/**
 * Class OperatorFactory
 *
 * @package Calculator
 */
abstract class OperatorFactory
{
    private static $operators = array(
        '+' => AdditionOperator::class,
        '-' => SubtractionOperator::class,
        '*' => MultiplicationOperator::class,
        '/' => DivisionOperator::class,
    );

    public static function getTokens()
    {
        return array_keys(self::$operators);
    }

    /**
     * @param $token
     *
     * @return string
     *
     * @throws \Exception
     */
    public static function getOperator(string $token)
    {
        if (!array_key_exists($token, self::$operators)) {
            return $token;
        }

        $class = self::$operators[$token];
        if (!class_exists($class)) {
            throw new \Exception('Operator class "' . $class . '" not found.');
        }

        $operator = new $class();
        if (!($operator instanceof AbstractOperator)) {
            throw new \Exception('Operator class "' . $class . '" must be instance of AbstractOperator and instance of ' . get_class($operator) . ' given.');
        }

        return $operator;
    }
}
