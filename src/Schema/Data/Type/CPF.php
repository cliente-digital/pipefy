<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use \stdclass;

class CPF extends AbstractType implements TypeInterface 
{
    private const int LENGTH = 11;
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
            throw new \Exception("CPF {$this->id()} only accept string. Found {$type}.");
        }
        $clearcpf = preg_replace( '/[^0-9]/is', '', $value);
 
        $length = strlen($clearcpf);

        if($length != self::LENGTH){
            $len = self::LENGTH;
            throw new \Exception("CPF Value can't have exatly 11 digits. Found {$length}.");
        }
        if(!$this->checkCpf($clearcpf))
            throw new \Exception("{$value} is not a valid CPF.");
    
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

    private function checkCpf($cpf): bool{
     
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }
}

