<?php
namespace Clientedigital\Pipefy\Graphql\Card;

use Clientedigital\Pipefy\Pipefy;
use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Entity;

class One 
{
    use GraphQL;

    private Pipefy $client;
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
        $this->client = new Pipefy;
    }

    public function get(){
        $cards = [];
        $gql = $this->getGQL("card-one");
        $gql->set("CARDID", $this->id);
        $gqlscript = $gql->script();
        $gqlResult = $this->client->request($gqlscript);
        return new Entity\Card($gqlResult->data->card);
    }
} 
