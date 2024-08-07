<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use \stdclass;

class Currency extends AbstractType implements TypeInterface 
{
    private ?float $value = null;

    public function value($value = null)
    {
        if(!is_null($value)){
            $this->validate($value);
            $this->value = number_format($value, 2);
        }

        if($this->required() && is_null($this->value))
            throw new \Exception("{$this->id()} is required and cannot be null");
        
        return $this->value;
    }

    private function validate($value)
    {
        if(!is_numeric($value) || is_string($value)){
            $type = gettype($value);
            throw new \Exception("Currency {$this->id()} only accept Numeric([0-9].{0,2}). Found {$type}.");
        }
    }

    /**
    * use gqlname to select the kind of script you need.
    * because sometimes a Data Type has a different representation in different gqls
    **/
    public function script($gqlname=null): string
     {
        $value = $this->value();

        if($gqlname == 'card-create')
            return "{field_id:\"{$this->id()}\", field_value: \"{$value}\"}";

        return "{fieldId:\"{$this->id()}\", value: \"{$value}\"}";
    }

}
