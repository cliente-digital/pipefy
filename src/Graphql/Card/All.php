<?php

namespace Clientedigital\Pipefy\Graphql\Card;
use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Entity;

class All 
{
    use GraphQL;

    private int $pipeId;
    private string $search;
    private array $filter = [];

    public function __construct(int $pipeId, string $search="")
    {
        $this->pipeId = $pipeId;
        $this->search = $search;
    }

    public function get(){
        return $this->load($this->pipeId);
    }

    private function load(int $pipeId){
        $page = $this->firstPage();
        $pageInfo = $page->data->cards->pageInfo; 
        while($pageInfo->hasNextPage){
            $nextPage = $this->nextPage($pageInfo->endCursor);
            $page->data->cards->edges = array_merge
                (
                    $page->data->cards->edges,
                    $nextPage->data->cards->edges
                );
            usleep(700);
            $pageInfo = $nextPage->data->cards->pageInfo; 

        }
        $this->setCache("pipe-{$pipeId}.cards", $page->data->cards->edges);
        $all = $page->data->cards->edges;
        $cards = [];
         foreach($all as $card){
            $card = new Entity\Card($card->node);
            $card->pipeId($this->pipeId);
            $cards[] = $card;
        }
        return $cards;

    }

    private function firstPage(){
        $cards = [];
        $gql = $this->getGQL("card-all_firstpage");
        $gql->set("PIPEID", $this->pipeId);
        $gql->set("SEARCH", $this->search);
        $gqlResult = $this->request($gql);
        return $gqlResult;
    }

    private function nextPage(string $nextCursor){
        $cards = [];
        $gql = $this->getGQL("card-all_nextpage");
        $gql->set("PIPEID", $this->pipeId);
        $gql->set("SEARCH", $this->search);
        $gql->set("ENDCURSOR", $nextCursor);
        return $this->request($gql);
    }

} 
