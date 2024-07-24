<?php
namespace Clientedigital\Pipefy\Graphql\Label;

use Clientedigital\Pipefy\Pipefy;
use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Entity;

class One 
{
    use GraphQL;

    private Pipefy $client;

    public function __construct()
    {
        $this->client = new Pipefy;
    }

    public function get(){
        $cards = [];
        $gql = $this->getGQL("pipe-one");
        $gql->set("PIPEID", $this->id);
        $gqlscript = $gql->script();
        $gqlResult = $this->client->request($gqlscript);
        return new Entity\Pipe($gqlResult->data->pipe, (bool) $gqlResult->data->pipe);
    }

    public function update(Entity\Label $resource)
    {
        $updateLabelInput = $resource->__newData();
        $gql = $this->getGQL("label-update");
        $gql->set('LABELID', $resource->id);
        //todo ser capaz de entender que parametros sao necessarios na gql
        // e verificar se algum parmetro a mais ou menos foi do requerido
        // foi preenchido e avisar o cliente.
        foreach($updateLabelInput as $vName => $vValue){
            $gql->set($vName, $vValue);
        }
        $gqlscript = $gql->script();
        //var_dump($gqlscript); return;
        $gqlResult = (new Pipefy())->request($gqlscript);
        var_dump($gqlResult);
    }
} 
