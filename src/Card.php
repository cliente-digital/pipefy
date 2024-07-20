<?php
namespace Clientedigital\Pipefy;
use Clientedigital\Pipefy\Card\All;

class Card 
{
    use GraphQL;

    private Pipefy $client;
    private array $filter = [];

    public function __construct()
    {
        $this->client = new Pipefy;
    }

    private function build(): void
    {
        $schema = $this->client->request( 
            $this->getGQL("card.build")
        );
        $this->setCache("schema", $schema);
    }

    public function search(int $pipeId){

    }

    public function all($pipeId, $cached = false)
    {
        if ($cached) {
            $all = $this->getCache("pipe-{$pipeId}.cards");
        } else {
            $allcards= new All();
            $all = $allcards->get($pipeId);
        }

        $cards = [];
         foreach($all as $node){
            $cards[] = new Entity\Card($node->node);
        }
        return $cards;
 
    }
    public function filter($dataName, $dataValue, $op='EQ'){

    }
} 
