<?php
namespace Clientedigital\Pipefy\Filter\Operator;

use Clientedigital\Pipefy\Entity\EntityInterface;
use \StdClass;

class Equal implements OperatorInterface
{
    public function evaluate(EntityInterface $item, $field, $value){
        return $item->$field == $value;
    }
} 
