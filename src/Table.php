<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql\Pipe\One;
use Clientedigital\Pipefy\Graphql\Label;
use Clientedigital\Pipefy\Entity;


    
class Table 
{
    private int $id;
    private ?Entity\Pipe $pipe=null;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function labels()
    {
        return (new Label\All())->fromTable($this->id); 
    }
} 
