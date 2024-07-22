<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql;
    
class Orgs
{
    public function All(){
        $orgs = [];
        $orgEntities = (new Graphql\Org\All())->get(); 
        foreach($orgEntities as $orgEntity){
            $orgs[] = $this->One($orgEntity->id);
        }
        return $orgs;
    }

    public function One(int $id){
        return new Org($id);
    }

} 
