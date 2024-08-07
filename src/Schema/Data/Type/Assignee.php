<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use \stdclass;

class Assignee extends AbstractType implements TypeInterface 
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
            throw new \Exception("ShortText {$this->id()} only accept string. Found {$type}.");
        }
        $length = strlen($value);
        if($length > self::MAXLENGTH){
            $maxlen = self::MAXLENGTH;
            throw new \Exception("Value can't be longer than {$maxlen}. Found {$length}.");
        }
    }

    /**
    * use gqlname to select the kind of script you need.
    * because sometimes a Data Type has a different representation in different gqls
    **/
    public function script($gqlname=null): string
     {
        return "{fieldId:\"{$this->id()}\", value: \"{$this->value()}\"}";
    }
}

