<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql;
use Clientedigital\Pipefy\Entity;
//use Clientedigital\Pipefy\Filter;


class Pipes
{
    private int $orgId;

    /**
    * Access the Organization Pipes defined by orgId
    */
    public function __construct(int $orgId)
    {
        $this->orgId = $orgId;
    }

    /**
    * Get All Pipes from Organization defined by orgId 
    * return it as an Array of Pipefy\Pipe Instances. 
    **/
    public function All(): array{
        $all= [];
        $entities = (new Graphql\Pipe\All($this->orgId))->get(); 
        foreach($entities as $entity){
            $all[] = $this->One($entity->id);
        }
        return $all;
    }

    /**
    * Get One Pipes from Organization defined by orgId 
    * return it as a Pipefy\Pipe Instances. 
    **/
    public function One(int $id): Pipe{
        return new Pipe($id);
    }
} 
