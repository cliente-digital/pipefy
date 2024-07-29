<?php
namespace Clientedigital\Pipefy\Graphql\Pipe;

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
        $cards = [];
        $gql = $this->getGQL("pipe-one");
        $gql->set("PIPEID", $this->id);
        $gqlscript = $gql->script();
        $gqlResult = $this->request($gqlscript);
        return new Entity\Pipe($gqlResult->data->pipe, (bool) $gqlResult->data->pipe);
    }

    public function updatePipe(array $updatePipeInput)
    {
        $gql = $this->getGQL("pipe-one.updatepipe");
        $gql->set('PIPEID', $this->id);
        foreach($updatePipeInput as $vName => $vValue){
            $gql->set($vName, $vValue);
        }
        $gqlscript = $gql->script();
        $gqlResult = $this->request($gqlscript);
    }

} 
