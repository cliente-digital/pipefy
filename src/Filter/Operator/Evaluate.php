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
            '=' => new Equal(),
            '<-' => new Contain()

        };
    }
} 
