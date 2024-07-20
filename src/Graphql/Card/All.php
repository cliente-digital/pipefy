<?php

namespace Clientedigital\Pipefy\Graphql\Card;
use Clientedigital\Pipefy\Pipefy;
use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Entity;

class All 
{
    use GraphQL;

    private Pipefy $client;
    private int $pipeId;
    private array $filter = [];

    public function __construct(int $pipeId)
    {
        $this->client = new Pipefy;
        $this->pipeId = $pipeId;
    }

    public function get(){
        return $this->load($this->pipeId);
    }

    private function load(int $pipeId){
        $page = $this->firstPage();
        $pageInfo = $page->data->allCards->pageInfo; 
        while($pageInfo->hasNextPage){
            $nextPage = $this->nextPage($pageInfo->endCursor);
            $page->data->allCards->edges = array_merge
                (
                    $page->data->allCards->edges,
                    $nextPage->data->allCards->edges
                );
            usleep(700);
            $pageInfo = $nextPage->data->allCards->pageInfo; 

        }
        $this->setCache("pipe-{$pipeId}.cards", $page->data->allCards->edges);
        $all = $page->data->allCards->edges;
        $cards = [];
         foreach($all as $card){
            $cards[] = new Entity\Card($card->node);
        }
        return $cards;

    }

    private function firstPage(){
        $cards = [];
        $gql = $this->getGQL("card.all_firstpage");
        $gql->set("PIPEID", $this->pipeId);
        $gqlscript = $gql->script();
        $gqlResult = $this->client->request($gqlscript);
        return $gqlResult;
    }

    private function nextPage(string $nextCursor){
        $cards = [];
        $gql = $this->getGQL("card.all_nextpage");
        $gql->set("PIPEID", $this->pipeId);
        $gql->set("ENDCURSOR", $nextCursor);
        $gqlscript = $gql->script();
        return $this->client->request($gqlscript);
    }

} 
