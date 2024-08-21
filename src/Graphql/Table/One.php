<?php
namespace Clientedigital\Pipefy\Graphql\Table;

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
        $gql = $this->getGQL("table-one");
        $gql->set("TABLEID", $this->id);
        $gqlResult = $this->request($gql);
        return new Entity\Table($gqlResult->data->table);
    }
} 
