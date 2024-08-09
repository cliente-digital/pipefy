<?php
namespace Clientedigital\Pipefy\Filter\Operator;

use Clientedigital\Pipefy\Entity\EntityInterface;
use \StdClass;

class LessThanEqual implements OperatorInterface
{
    public function evaluate(EntityInterface $item, $field, $value){
        $fieldvalue = $item->$field; 

        if(is_null($item->$field) && is_null($value))
            return true;
 
        if(is_null($fieldvalue))
            return false;
        return $fieldvalue <= $value;
    }
} 
