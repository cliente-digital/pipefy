<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use \stdclass;
use \DateTime;

class Time extends AbstractType implements TypeInterface 
{
    private ?string $value = null;
    private const string PATTERN = '/^([01][0-9]|2[0-3]):([0-5][0-9])$/m';
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
        preg_match_all(self::PATTERN, $value, $matches, PREG_SET_ORDER, 0);

        if(count($matches)==0){
            throw new \Exception("Time {$this->id()} only accept 24h time format 00:00-23:59. Found {$value}.");
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
