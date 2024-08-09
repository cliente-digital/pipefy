<?php
namespace Clientedigital\Pipefy\Filter\Operator;

use Clientedigital\Pipefy\Entity\EntityInterface;
use \StdClass;

class Evaluate 
{
    public function check(EntityInterface $item, array $filter){
        $operator = $this->getOperator($filter['op']);
        return $operator->evaluate($item, $filter['field'], $filter['value']);
    }

    private function getOperator(string $operator): OperatorInterface
    {
        return match($operator){
            OP::Equal => new Equal(),
            OP::NotEqual => new NotEqual(),
            OP::IN => new Contain(),
            OP::NIN => new NotContain(),
            OP::GT => new GreaterThan(),
            OP::GTE => new GreaterThanEqual(),
            OP::LT => new LessThan(),
            OP::LTE => new LessThanEqual()
        };
    }
} 
