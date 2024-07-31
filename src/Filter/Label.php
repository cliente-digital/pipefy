<?php
namespace Clientedigital\Pipefy\Filter;

use Clientedigital\Pipefy\Entity\EntityInterface;
use \StdClass;

class Label implements FilterInterface
{

    public function __construct(){}

    private $fields = ['color', 'id', 'name'];
    private array $afterFilters = [];

    private function addToFilterArray($name, $value)
    {
        array_push($this->filters[$name], $value);
        $this->filters[$name] = array_unique($this->filters[$name]);
        return $this;
    }

    public function by($field, $op, $value)
    {
        if(!in_array($field, $this->fields))
            throw new \Exception("Label filter can't filter by {$fields}" .
                "Supported fields are: ". implode(", ", $this->fields)
            );
        array_push($this->afterFilters, ['field' => $field, 'op'=>$op, 'value'=>$value]);
    }

    public function script(): string
    {
        return "";
    }

    public function check(EntityInterface $item): bool
    {
        $evaluator = new Operator\Evaluate();
        foreach($this->afterFilters as $filter){
            if (!$evaluator->check($item, $filter))
                return false;
        }
        return true;
    }
} 
