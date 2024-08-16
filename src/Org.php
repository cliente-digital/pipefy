<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql\Org\One;
use Clientedigital\Pipefy\Entity;
    
class Org 
{
    private int $id;

    /**
    * Access one Organization defined by id.
    **/
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
    * return the Organization(id) Entity
    **/
    public function get(): Entity\Org
    {
        return (new One($this->id))->get(); 
    }

    /**
    * return all Pipes from Organization(id).
    */
    public function pipes(): array{
        $pipes = $this->get()->pipes;
        foreach($pipes as $idx => $pipe){
            $pipes[$idx]=  new Pipe($pipe->id);
        }
        return $pipes;
    } 

    /**
    * return a pipe from the Organization(id)
    * and throw Exception if not found.
    */
    public function pipe(int $id): Pipe
    {
        $pipes = $this->pipes();
        foreach($pipes as $pipe){
            if($pipe->id == $id)
                return $pipe;
        }
        throw new \Exception("Pipe {$id} not found at Organization {$this->id}.");
    }

    /**
    * update the organization(id) data.
    * throw an Exception if you try to update and organization using an entity with
    * different id that you set on constructor.
    **/ 
    public function update(Entity\Org $org): bool
    {
        if($this->id != $org->id)
            throw new \Exception("This Org can only update the organization id {$this->id}. Entity Found {$org->id}.");

        $newValues = $org->__newData();

        return (new One($this->id))
            ->updateOrganizationInput($newValues); 
    }
} 
