<?php
namespace Clientedigital\Pipefy\Filter\Operator;

use Clientedigital\Pipefy\Entity\EntityInterface;
use \StdClass;

class Contain implements OperatorInterface
{
    public function evaluate(EntityInterface $item, $field, $value){
        $fieldvalue = $item->$field; 

        if(is_null($item->$field) && is_null($value))
            return true;
 
        if(is_null($fieldvalue))
            return false;
        if(is_string($value))
            return $this->inStr($fieldvalue, $value);
        else if (is_array($value))
            return $this->inArray($fieldvalue, $value);
    }

    private function inStr($field, $value): bool
    {
        return strpos($field, $value)!==false;
    }

    private function inArray($field, $values): bool
    {
        foreach($values as $value){
            if(!$this->inStr($field, $value))
                return false;
        }
        return true;
    }

} 
