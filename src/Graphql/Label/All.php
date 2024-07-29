<?php
namespace Clientedigital\Pipefy\Graphql\Label;

use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Entity;

class All 
{
    use GraphQL;

    public function fromPipe(int $pipeId){
        $all = [];
        $gql = $this->getGQL("label-pipeall");
        $gql->set("PIPEID", $pipeId);
        $gqlResult = $this->request($gql);

        foreach($gqlResult->data->pipe->labels as $label){
            $label->parentId = $pipeId;
            $label->parentType = 'Pipe'; 
            $all[] = new Entity\Label($label);
        }

        return $all;

    }

    public function fromTable(int $tableId){
        $all = [];
        $gql = $this->getGQL("label-tableall");
        $gql->set("TABLEID", $tableId);
        $gqlResult = $this->request($gql);

        foreach($gqlResult->data->table->labels as $label){
            $label->parentId = $tableId;
            $label->parentType = 'Table'; 
            $all[] = new Entity\Label($label);
        }

        return $all;

    }

    public function fromCard(int $cardId){
        $all = [];
        $gql = $this->getGQL("label-cardall");
        $gql->set("CARDID", $cardId);
        $gqlResult = $this->request($gql);

        foreach($gqlResult->data->card->labels as $label){
            $label->parentId = $cardId;
            $label->parentType = 'Card'; 
            $all[] = new Entity\Label($label);
        }

        return $all;

    }
} 
