<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use \stdclass;

class Number extends AbstractType implements TypeInterface 
{
    private ?float $value = null;

    public function value($value = null)
    {
        if(!is_null($value)){
            $this->validate($value);
            $this->value = $value;
        }

        if($this->required() && is_null($this->value))
            throw new \Exception("{$this->id()} is required and cannot be null");
        
        return $this->value;
    }

    private function validate($value)
    {
        if(!is_numeric($value) || is_string($value)){
            $type = gettype($value);
            throw new \Exception("Number {$this->id()} only accept Numeric([0-9].{0,2}). Found {$type}.");
        }
    }

    /**
    * use gqlname to select the kind of script you need.
    * because sometimes a Data Type has a different representation in different gqls
    **/
    public function script($gqlname=null): string
     {
        if($gqlname == 'card-create')
            return "{field_id:\"{$this->id()}\", field_value: \"{$this->value()}\"}";

        return "{fieldId:\"{$this->id()}\", value: \"{$this->value()}\"}";
    }

}

