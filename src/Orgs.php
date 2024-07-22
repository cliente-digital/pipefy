<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql\Org as GraphQLOrg;
    
class Orgs
{
    public function All(){
        $orgs = [];
        $orgEntities = (new GraphQLOrg\All())->get(); 
        foreach($orgEntities as $orgEntity){
            $orgs[] = $this->One($orgEntity->id);
        }
        return $orgs;
    }

    public function One(int $id){
        return new Org($id);
    }

} 
