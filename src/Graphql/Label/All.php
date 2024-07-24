<?php
namespace Clientedigital\Pipefy\Graphql\Label;

use Clientedigital\Pipefy\Pipefy;
use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Entity;

class All 
{
    use GraphQL;

    public function fromPipe(int $pipeId){
        $all = [];
        $gql = $this->getGQL("label-pipeall");
        $gql->set("PIPEID", $pipeId);
        $gqlscript = $gql->script();
        $gqlResult = (new Pipefy())->request($gqlscript);

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
        $gqlscript = $gql->script();
        $gqlResult = (new Pipefy())->request($gqlscript);

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
        $gqlscript = $gql->script();
        $gqlResult = (new Pipefy())->request($gqlscript);

        foreach($gqlResult->data->card->labels as $label){
            $label->parentId = $cardId;
            $label->parentType = 'Card'; 
            $all[] = new Entity\Label($label);
        }

        return $all;

    }




} 
