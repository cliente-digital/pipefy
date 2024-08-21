<?php
namespace Clientedigital\Pipefy\Graphql\Table;

use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Entity;

class All 
{
    use GraphQL;

    private int $orgid;

    public function __construct(int $orgid)
    {
        $this->orgid = $orgid;
    }

    public function get(){
        $all = [];
        $gql = $this->getGQL("table-all");
        $gql->set("ORGID", $this->orgid);
        $gqlResult = $this->request($gql);
        foreach($gqlResult-> data->organization->tables->edges as $table){
            $all[] = new Entity\Table($table->node);
        }
        return $all;

    }


} 
