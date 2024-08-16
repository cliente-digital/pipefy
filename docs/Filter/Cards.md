<?php
namespace Clientedigital\Pipefy\Filter;

use Clientedigital\Pipefy\Entity\EntityInterface;
use \StdClass;

class Cards implements FilterInterface
{
    public const STRATEGY_UNION = 'union';
    public const STRATEGY_INTERSEC = 'intersection';

    public function __construct(){}

    private array $filters = [
        'assignee_ids' => [],
        'ignore_ids' => [],
        'label_ids' => [],
        'title' => null,
        'include_done' => null,
        'inbox_email_read' => null,
        'search_strategy' => self::STRATEGY_UNION
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

    public function filterStrategy(string $strategy)
    {
        if(!in_array($strategy, [self::STRATEGY_UNION, self::STRATEGY_INTERSEC]))
            throw new \Exception("Invalid Filter Strategy. check documentation");

        $this->filterStrategy = $strategy;
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
