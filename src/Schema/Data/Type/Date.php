<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use \stdclass;
use \DateTime;

class Date extends AbstractType implements TypeInterface 
{
    private ?DateTime $value = null;

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
        if(! $value instanceof DateTime ){
            $type = gettype($value);
            throw new \Exception("Date {$this->id()} only accept \DateTime values. Found {$type}.");
        }
    }

    /**
    * use gqlname to select the kind of script you need.
    * because sometimes a Data Type has a different representation in different gqls
    **/
    public function script($gqlname=null): string
     {
        if($gqlname == 'card-create')
            return "{field_id:\"{$this->id()}\", field_value: \"{$this->value()->format("d/m/Y")}\"}";

        return "{fieldId:\"{$this->id()}\", value: \"{$this->value()->format(DATE_ATOM)}\"}";
    }
}
