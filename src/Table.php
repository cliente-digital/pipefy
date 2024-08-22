<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql;
use Clientedigital\Pipefy\Entity;
use Clientedigital\Pipefy\Filter;



    
class Table 
{
    private int $id;
    private ?Entity\Table $table = null;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function id(): int{
        return $this->id;
    }

    public function entity()
    {
        if(is_null($this->table))
            $this->table= (new Graphql\Table\One($this->id))->get(); 
        return $this->table;
    }

    public function labels(?Filter\Label $filter=null)
    {
        $labels =(new Graphql\Label\All())->fromTable($this->id); 
        if(is_null($filter))
            return $labels;
        foreach($labels as $idx => $label){
            if(!$filter->check($label))
               unset($labels[$idx]); 
        }
        sort($labels);
        return $labels;
    }

    public function records(?Filter\Record $filter=null)
    {
        $all= new Graphql\Record\All($this->id);  
        if(!is_null($filter))
            $all= new Graphql\Record\All($this->id, $filter->script());
 
        $records = $all->get();

        foreach($records as $record){
            if(is_null($filter))
                yield $record;

            else if($filter->check($record))
                yield $record;
        }
    }

    public function record(int $id)
    {
        return New Record($id);
    }
} 
