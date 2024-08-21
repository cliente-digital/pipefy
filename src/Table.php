<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql\Pipe\One;
use Clientedigital\Pipefy\Graphql\Label;
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

    }

    public function record(int $id)
    {

    }
} 
