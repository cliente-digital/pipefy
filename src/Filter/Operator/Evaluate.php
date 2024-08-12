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
            OP::EQ->value => new Equal(),
            OP::NEQ->value => new NotEqual(),
            OP::IN->value => new Contain(),
            OP::NIN->value => new NotContain(),
            OP::GT->value => new GreaterThan(),
            OP::GTE->value => new GreaterThanEqual(),
            OP::LT->value => new LessThan(),
            OP::LTE->value => new LessThanEqual()
        };
    }
} 
