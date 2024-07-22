<?php

namespace Clientedigital\Pipefy\Graphql\Org;
use Clientedigital\Pipefy\Pipefy;
use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Entity;

class All 
{
    use GraphQL;

    private Pipefy $client;

    public function __construct()
    {
        $this->client = new Pipefy;
    }

    public function get(){
        return $this->load();
    }

    private function load(){
        $orgs= [];
        $gql = $this->getGQL("org-all");
        $gqlscript = $gql->script();
        $gqlResult = $this->client->request($gqlscript);
        foreach($gqlResult->data->organizations as $org){
            $orgs[] = new Entity\Org($org);
        }
        return $orgs;
    }
} 
