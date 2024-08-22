<?php
namespace Clientedigital\Pipefy\Filter;

use Clientedigital\Pipefy\Entity\EntityInterface;
use \StdClass;

class Records implements FilterInterface
{

    public const ASC_ORDER = 'asc';
    public const DESC_ORDER = 'desc';

    public function __construct(){}

    private array $filters = [
        'assignee_ids' => [],
        'ignore_ids' => [],
        'label_ids' => [],
        'orderDirection' => null,
        'orderField' => null,
        'title' => null,
        'include_done' => null
    ]; 

    private array $afterFilters = [];

    private function addToFilterArray($name, $value)
    {
        array_push($this->filters[$name], $value);
        $this->filters[$name] = array_unique($this->filters[$name]);
        return $this;
    }

    public function by($field, $op, $value)
    {
        array_push($this->afterFilters, ['field' => $field, 'op'=>$op, 'value'=>$value]);
    }

    public function script(): string
    {
        $applyFilter = [];
        foreach($this->filters as $name => $value){
            if(is_array($value) && count($value)>0){
                $applyFilter[] = "{$name}: [". explode(",",$value)."]";
                $hasFilters = true;
            }
            else if (!is_array($value) && !is_null($value)){
                if($name == 'title') $value = "\"{$value}\"";
                else if (is_bool($value)) $values = $value?"true":"false";
                $applyFilter[] = "{$name} : {$value}";

                $hasFilters = true;
            }
        }
        if(count($applyFilter)>0)
            return ", search :{". implode(",",$applyFilter)."}";
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

    public function order(string $byField, string $order)
    {
        if(!in_array($strategy, [self::ASC_ORDER, self::DESC_ORDER]))
            throw new \Exception("Invalid Filter Ordenation ORDER. check documentation");
        $this->filters['orderField'] = $byField;
        $this->filters['orderDirection']= $order;
    }
    
    public function assigneeTo(int $assigneeId)
    {
        return $this->addToFilterArray('assignee_ids', $assigneeId);
    }
    
    public function IgnoreCard(int $cardId)
    {
        return $this->addToFilterArray('ignore_ids', $cardId);
    }

    public function labeledWith(int $labelId)
    {
        return $this->addToFilterArray('label_ids', $labelId);
    }

    public function titled(string $title)
    {
        $this->filters['title'] = $title;
        return $this;
    }

    public function includeDone(bool $include)
    {
        $this->filters['include_done'] = $include? true : null;
        return $this;
    }
} 
