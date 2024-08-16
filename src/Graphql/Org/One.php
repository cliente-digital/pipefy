<?php

namespace Clientedigital\Pipefy\Graphql\Org;
use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Entity;

class One 
{
    use GraphQL;

    private int $id;
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function get(){
        return $this->load();
    }

    private function load(){
        $gql = $this->getGQL("org-one");
        $gql->set('ORGID', $this->id);
        $gqlResult = $this->request($gql);
        return new Entity\Org($gqlResult->data->organization);
    }

    public function updateOrganizationInput(array $updateOrganizationInput)
    {
        $gql = $this->getGQL("org-one.updateorganizationinput");
        $gql->set('ORGID', $this->id);
        foreach($updateOrganizationInput as $vName => $vValue){
            $gql->set($vName, $vValue);
        }
        $gqlResult = $this->request($gql);
        return true;
    }
} 
