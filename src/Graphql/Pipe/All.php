<?php
namespace Clientedigital\Pipefy\Graphql\Pipe;

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
        $gql = $this->getGQL("pipe-all");
        $gql->set("ORGID", $this->orgid);
        $gqlResult = $this->request($gql);

        foreach($gqlResult-> data->organization->pipes as $pipe){
            $all[] = new Entity\Pipe($pipe);
        }
        return $all;

    }


} 
