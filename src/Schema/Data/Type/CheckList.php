<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use \stdclass;

class CheckList extends AbstractType implements TypeInterface 
{
    private ?array $value = null;

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
        $options = $this->options();

        if(!is_array($value)){
            $type = gettype($value);
            throw new \Exception("checkList {$this->id()} only accept Array . Found {$type}.");
        }
        foreach($value as $v){
            if(!is_string($v)){
                $type = gettype($v);
                throw new \Exception("checkList Item {$this->id()} need be string. Found {$v}:{$type}.");
            }
            if(!in_array($v, $options)){
                throw new \Exception("CheckList {$this->id()} only accept [".implode(", ", $options) ."]. Found '{$v}'.");
            }
        }
    }

    /**
    * use gqlname to select the kind of script you need.
    * because sometimes a Data Type has a different representation in different gqls
    **/
    public function script($gqlname=null): string
     {
        if($gqlname == 'card-create')
            return "{field_id:\"{$this->id()}\", field_value: \"[".implode(", ", $this->value())."]\"}";

        return "{fieldId:\"{$this->id()}\", value: \"{$this->value()}\"}";
    }
}
