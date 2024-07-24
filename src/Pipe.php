<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql\Pipe\One;
use Clientedigital\Pipefy\Graphql\Label;
use Clientedigital\Pipefy\Entity;


    
class Pipe 
{
    private int $id;
    private ?Entity\Pipe $pipe=null;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function load(){
        return (new One($this->id))->get(); 
    }

    public function get()
    {
        if(is_null($this->pipe))
            $this->pipe = $this->load();
        return $this->pipe;
    }

    public function update(Entity\EntityInterface $resource)
    {
        $newValues = $resource->__newData();
        return (new One($this->id))
            ->updatePipe($newValues); 
    }

    public function labels()
    {
        return (new Label\All())->fromPipe($this->id); 
    }
} 
