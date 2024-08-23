<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql;
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

    public function id(): int{
        return $this->id;
    }


    /**
    * return Entity\Org 
    **/
    public function entity(): Entity\Org
    {
        return (new Graphql\Org\One($this->id))->get(); 
    }

    /**
    * update the organization(id) data.
    * throw an Exception if you try to update and organization using an entity with
    * different id that you set on constructor.
    **/ 
    public function update(Entity\Org $org): bool
    {
        if($this->id != $org->id)
            throw new \Exception("Entity($org->id) is not from this Org({$this->id}).");

        $newValues = $org->__newData();

        return (new One($this->id))
            ->updateOrganizationInput($newValues); 
    }

    /**
    * return the Organization Pipes Array.
    */
    public function pipes(): array{
        $all= [];
        $entities = (new Graphql\Pipe\All($this->id))->get(); 
        foreach($entities as $entity){
            $all[] = new Pipe($entity->id);
        }
        return $all;
    } 

    /**
    * return a pipe from the Organization(id)
    * and throw Exception if not found.
    */
    public function pipe(string|int $id): Pipe
    {
        $pipes = $this->pipes();
        foreach($pipes as $pipe){
            if( 
                (is_int($id) && $pipe->id() == $id) ||
                (is_string($id) && $pipe->suid() == $id) 
             )
             return $pipe;
        }
        throw new \Exception("Organization({$this->id}) has no Pipe({$id}).");
    }

    /**
    * return the Organization Tables Array.
    */
    public function tables(): array{
        $all= [];
        $entities = (new Graphql\Table\All($this->id))->get(); 
        foreach($entities as $entity){
            $all[] = new Table($entity->internal_id);
        }
        return $all;
    } 

    /**
    * return a table from the Organization(id)
    * and throw Exception if not found.
    */
    public function table(int $id): Pipe
    {
        $tables = $this->tables();
        foreach($tables as $table){
            if($table->id() == $id)
                return $table;
        }
        throw new \Exception("Organization({$this->id}) has no Table({$id}).");
    }
} 
