<?php
namespace Clientedigital\Pipefy\Card;
use Clientedigital\Pipefy\GraphQL;
use Clientedigital\Pipefy\Pipefy;
use Clientedigital\Pipefy\Entity;

class All 
{
    use GraphQL;

    private Pipefy $client;
    private int $pipeId;
    private array $filter = [];

    public function __construct()
    {
        $this->client = new Pipefy;
    }

    public function get(int $pipeId){
        $this->pipeId = $pipeId;
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
        return $page->data->allCards->edges;
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
