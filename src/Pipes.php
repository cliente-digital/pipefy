<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql;
use Clientedigital\Pipefy\Entity;
//use Clientedigital\Pipefy\Filter;


class Pipes
{

    private array $pipes = [];
    private int $orgId;

    public function __construct(int $orgId)
    {
        $this->orgId = $orgId;
    }

    public function All(){
        $all= [];
        $entities = (new Graphql\Pipe\All($this->orgId))->get(); 
        foreach($entities as $entity){
            $all[] = $this->One($entity->id);
        }
        return $all;
    }

    public function One(int $id){
        return new Pipe($id);
    }
} 
