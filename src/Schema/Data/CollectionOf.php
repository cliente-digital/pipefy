<?php
namespace Clientedigital\Pipefy\Schema\Data;
use \stdclass;

class CollectionOf{

    private array $fields = [];
    private $of = null;
    public function __construct($type)
    {
        $this->of = $type; 
    }
    public function add($field)
    {
        if($field instanceof $this->of)
           return $this->fields[] = $field;
        $fieldType = get_class($field); 
        throw new \EXception("Error: Collection of {$this->of}.Found {$fieldType}");
    }

    public function count(): int{
        return count($this->fields);
    }

    public function script():string
    {
        $script = []; 
        foreach($this->fields as $field){
            $script[] = $field->script();
        }
        return implode(", ", $script);
    }
}

