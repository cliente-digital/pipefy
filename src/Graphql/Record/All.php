<?php

namespace Clientedigital\Pipefy\Graphql\Record;
use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Entity;
use Clientedigital\Pipefy\Cache;

class All 
{
    use GraphQL;

    private int $tableId;
    private string $search;
    private array $filter = [];

    public function __construct(int $tableId, string $search="")
    {
        $this->tableId= $tableId;
        $this->search = $search;
    }

    public function get(){
        return $this->load($this->tableId);
    }

    private function load(int $tableId){
        var_dump("loading records");
        $cache = new Cache(); 
        if(!$cache->info('record-all_firstpage')->valid)
            $cache->clear('record-all_', null, true);

        $page = $this->firstPage();
        var_dump($page);
        $pageInfo = $page->data->table_records->pageInfo; 
        while($pageInfo->hasNextPage){
            $nextPage = $this->nextPage($pageInfo->endCursor);
            $page->data->table_records->edges = array_merge
                (
                    $page->data->table_records->edges,
                    $nextPage->data->table_records->edges
                );
            $pageInfo = $nextPage->data->table_records->pageInfo; 

        }
        $all = $page->data->table_records->edges;
        $records= [];
         foreach($all as $record){
            $record = new Entity\Record($record->node);
            $record->tableId($this->tableId);
            $records[] = $record;
        }
        return $records;

    }

    private function firstPage(){
        $cards = [];
        $gql = $this->getGQL("record-all_firstpage");
        $gql->set("TABLEID", $this->tableId);
        $gql->set("SEARCH", $this->search);
        $gqlResult = $this->request($gql);
        return $gqlResult;
    }

    private function nextPage(string $nextCursor){
        $cards = [];
        $gql = $this->getGQL("record-all_nextpage");
        $gql->set("TABLEID", $this->tableId);
        $gql->set("SEARCH", $this->search);
        $gql->set("ENDCURSOR", $nextCursor);
        return $this->request($gql);
    }

} 
