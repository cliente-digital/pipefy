<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use \stdclass;

class Email extends AbstractType implements TypeInterface 
{
    private ?string $value = null;

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
        if(!is_string($value)){
            $type = gettype($value);
            throw new \Exception("Email {$this->id()} only accept string. Found {$type}.");
        }

        if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
            throw new \Exception("Email {$this->id()} is not a valid e-mail. Found {$value}.");
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
