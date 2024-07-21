<?php
namespace Clientedigital\Pipefy\Filter\Operator;

use Clientedigital\Pipefy\Entity\EntityInterface;
use \StdClass;

class Contain implements OperatorInterface
{
    public function evaluate(EntityInterface $item, $field, $value){
        if(is_string($value))
            return $this->inStr($item->$field, $value);
        else if (is_array($value))
            return $this->inArray($iitem->$field, $value);
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
