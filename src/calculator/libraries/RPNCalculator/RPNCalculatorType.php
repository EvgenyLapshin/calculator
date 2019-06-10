<?php

namespace Calculator;

/**
 * Class Calculator
 *
 * This class uses Reverse Polish Notation
 *
 * @link https://en.wikipedia.org/wiki/Reverse_Polish_notation
 */
class RPNCalculatorType implements CalculatorType
{
    const OPENED_BRACKET = '(';
    const CLOSED_BRACKET = ')';

    private $postfix = [];
    private $stack = [];

    /**
     * @param string $infix
     *
     * @return float
     *
     * @throws \Exception
     */
    public function calculate(string $infix): float
    {
        $postfix = $this->infixToPostfix($infix);
        $stack = [];

        foreach ($postfix as $token) {
            if (is_numeric($token)) {
                array_unshift($stack, $token);
            } elseif ($token instanceof AbstractOperator) {
                $params = [];
                for ($i = 1; $i <= $token->getOperandsCount(); $i++) {
                    if (count($stack) == 0) {
                        $params[] = 0;
                    } else {
                        $params[] = array_shift($stack);
                    }
                }
                $result = $token->execute(array_reverse($params));
                array_unshift($stack, $result);
            }
        }
        $result = array_shift($stack);

        return $result;
    }

    /**
     * Infix notation to postfix (Reverse Polish Notation)
     *
     * @param string $infix
     *
     * @return array
     *
     * @throws \Exception
     */
    private function infixToPostfix(string $infix): array
    {
        $tokens = $this->prepareInfix($infix);
        $tokens = array_map([OperatorFactory::class, 'getOperator'], $tokens);

        foreach ($tokens as $token) {
            if (is_numeric($token)) {
                $this->postfix[] = $token;
            } elseif ($token === self::OPENED_BRACKET) {
                array_unshift($this->stack, $token);
            } elseif ($token === self::CLOSED_BRACKET) {
                $tmp = '';
                while ($tmp <> self::OPENED_BRACKET) {
                    if (count($this->stack) == 0) {
                        throw new \Exception('Parse error.');
                    }
                    $tmp = array_shift($this->stack);
                    if ($tmp != self::OPENED_BRACKET) {
                        $this->postfix[] = $tmp;
                    }
                }
            } elseif ($token instanceof AbstractOperator) {
                while (array_key_exists(0, $this->stack) && $this->stack[0] instanceof AbstractOperator) {
                    if ($token->comparePriority($this->stack[0]) == 1 && $this->stack[0]->getAssociative() == AbstractOperator::ASSOCIATIVE_LEFT) {
                        break;
                    }
                    if ($token->comparePriority($this->stack[0]) >= 0 && $this->stack[0]->getAssociative() == AbstractOperator::ASSOCIATIVE_RIGHT) {
                        break;
                    }
                    $this->postfix[] = array_shift($this->stack);
                }
                array_unshift($this->stack, $token);
            }
        }

        foreach ($this->stack as $token) {
            if (!($token instanceof AbstractOperator)) {
                throw new \Exception('Parse error.');
            }
            $this->postfix[] = $token;
        }

        $result = $this->postfix;

        $this->postfix = [];
        $this->stack = [];

        return $result;
    }

    /**
     * @param string $infix
     *
     * @return array
     */
    private function prepareInfix(string $infix): array
    {
        $infix = (string)$infix;

        $operators = OperatorFactory::getTokens();
        $operators = array_map('preg_quote', $operators);
        $operators = '(' . implode(')|(', $operators) . ')';
        $pattern = '#(\\d+(\.?\\d+|\\d*))|(\()|(\))|' . $operators . '#';
        $tokens = [];
        preg_match_all($pattern, $infix, $tokens);

        if (array_key_exists(0, $tokens)) {
            $tokens = $tokens[0];
        }

        return $tokens;
    }
}
