<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql;
    
class Orgs
{

    /**
    *   list all Organizations the configured api key can access.
    */
    public function All() :array {
        $orgs = [];
        $orgEntities = (new Graphql\Org\All())->get(); 
        foreach($orgEntities as $orgEntity){
            $orgs[] = $this->One($orgEntity->id);
        }
        return $orgs;
    }

    /**
    * retrieve one organization the configured api key can access
    */
    public function One(int $id){
        return new Org($id);
    }

} 
