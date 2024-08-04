<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;
use \stdclass;

interface TypeInterface{
    public function __construct(stdclass $definition);
    public function value($value = null);
}

// cada pipey tem seus campos
// a definition precisa ser carregada do pipe, pelo name;

