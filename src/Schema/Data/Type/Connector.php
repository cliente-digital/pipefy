<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use \stdclass;

class Connector extends AbstractType implements TypeInterface 
{
    private $value = null;

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
        if(!is_scalar($value)){
            $type = gettype($value);
            throw new \Exception("Connector {$this->id()} only accept scalar values. Found {$type}.");
        }
    }

    public function script(): string
    {
        return $this->value();
    }
}
