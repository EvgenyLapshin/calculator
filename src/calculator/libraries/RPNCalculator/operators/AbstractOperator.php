<?php

namespace Calculator;

/**
 * Class AbstractOperator
 *
 * @package Calculator
 */
abstract class AbstractOperator
{
    const ASSOCIATIVE_LEFT = 0;
    const ASSOCIATIVE_RIGHT = 1;

    private $associative_map = array(
        self::ASSOCIATIVE_LEFT,
        self::ASSOCIATIVE_RIGHT
    );

    protected $priority = null;
    protected $token = null;
    protected $operandsCount = null;
    protected $associative = null;

    abstract protected function doExecute(array $operands);

    /**
     * @param array $operands
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function execute(array $operands)
    {
        if (count($operands) != $this->getOperandsCount()) {
            throw new \Exception('Operands count must be equal ' . $this->getOperandsCount());
        }

        $operands = array_values($operands);

        return $this->doExecute($operands);
    }

    /**
     * @return null
     *
     * @throws \Exception
     */
    public function getAssociative()
    {
        if (is_null($this->associative)) {
            throw new \Exception('Associative is empty');
        }

        if (!in_array($this->associative, $this->associative_map)) {
            throw new \Exception('Invalid associative value');
        }

        return $this->associative;
    }

    /**
     * @return null
     *
     * @throws \Exception
     */
    public function getOperandsCount()
    {
        if (is_null($this->operandsCount)) {
            throw new \Exception('Operands count is empty');
        }

        return $this->operandsCount;
    }

    /**
     * @param AbstractOperator $operator
     *
     * @return int
     *
     * @throws \Exception
     */
    public function comparePriority(AbstractOperator $operator)
    {
        if (is_null($this->priority)) {
            throw new \Exception('Priority is empty');
        }

        $num = $this->priority - $operator->priority;

        return ($num > 0) ? 1 : (($num < 0) ? -1 : 0);
    }

    /**
     * @return null
     *
     * @throws \Exception
     */
    public function __toString()
    {
        if (is_null($this->token)) {
            throw new \Exception('Token is empty');
        }

        return $this->token;
    }
}
