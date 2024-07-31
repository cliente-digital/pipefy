<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql\Pipe\One;
use Clientedigital\Pipefy\Graphql\Label;
use Clientedigital\Pipefy\Entity;
use Clientedigital\Pipefy\Filter;



    
class Table 
{
    private int $id;
    private ?Entity\Pipe $pipe=null;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function labels(?Filter\Cards $filter=null)
    {
        $labels  = (new Label\All())->fromTable($this->id); 
        if(is_null($filter))
            return $labels;
        foreach($labels as $idx => $label){
            if(!$filter->check($label))
               unset($labels[$idx]); 
        }
        sort($labels);
        return $labels;
 
    }
} 
