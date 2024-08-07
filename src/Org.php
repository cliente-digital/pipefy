<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql\Org\One;
use Clientedigital\Pipefy\Entity;
    
class Org 
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function load(){
        return (new One($this->id))->get(); 
    }

    public function get()
    {
        return $this->load();
    }

    public function pipes(){
        $pipes = $this->get()->pipes;
        foreach($pipes as $idx => $pipe){
            $pipes[$idx]=  new Pipe($pipe->id);
        }
        return $pipes;
    } 
    /* can only update his own resource */
    public function update(Entity\EntityInterface $resource)
    {
        $newValues = $resource->__newData();

        return (new One($this->id))
            ->updateOrganizationInput($newValues); 
 
    }
} 
