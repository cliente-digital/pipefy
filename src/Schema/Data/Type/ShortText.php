<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use \stdclass;

class ShortText extends AbstractType implements TypeInterface 
{
    private const int MAXLENGTH = 255;
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

    public function script(): string
    {
        return "{fieldId:\"{$this->id()}\", value: \"{$this->value()}\"}";
    }
}
