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
        $gqlResult = $this->request($gql);
        return new Entity\Pipe($gqlResult->data->pipe, (bool) $gqlResult->data->pipe);
    }

    public function updatePipe(array $updatePipeInput)
    {
        $gql = $this->getGQL("pipe-one.updatepipe");
        $gql->set('PIPEID', $this->id);
        foreach($updatePipeInput as $vName => $vValue){
            $gql->set($vName, $vValue);
        }
        $gqlResult = $this->request($gql);
    }

    public function createCard(array $createCardInput)
    {
        $gql = $this->getGQL("card-create");
        $gql->set('PIPEID', $this->id);
        foreach($createCardInput as $vName => $vValue){
            if(
                $vValue instanceof \Clientedigital\Pipefy\Schema\Data\CollectionOf || 
                $vValue instanceof \Clientedigital\Pipefy\Schema\Data\Type\TypeInterface
              )
                $vValue = $vValue->script('card-create');
 
            $gql->set($vName, $vValue);
        }
        $gqlResult = $this->request($gql);
        if(isset($gqlResult->errors))
            return $gqlResult->errors[0]->message;
        if(isset($gqlResult->data->createCard))
            return (int) $gqlResult->data->createCard->card->id;
    }
} 
