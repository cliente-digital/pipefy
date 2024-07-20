<?php
namespace Clientedigital\Pipefy;
use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Graphql\Card\All;

class Cards
{
    use GraphQL;

    private Pipefy $client;
    private int $pipeId=0;
    private array $filter = [];
    private array $cards = [];

    public function __construct(int $pipeId, $cached = Pipefy::UNCACHED)
    {
        $this->pipeId = $pipeId;
        $this->client = new Pipefy;
        $this->load($cached);
    }

    private function load(bool $cached)
    {
        if ($cached) {
            $all = $this->getCache("pipe-{$this->pipeId}.cards");
            $cards = [];
             foreach($all as $node){
                $cards[] = new Entity\Card($node->node);
            }
            $this->cards = $cards;
        } else {
            $allcards= new All($this->pipeId);
            $this->cards = $allcards->get();
        }
    }

    public function get(){
        foreach($this->cards as $card){
            yield $card;
        }
    }

    public function filter($dataName, $dataValue, $op='EQ'){
        $cards = $this->get();
        foreach($cards as $card){
            //if
        }
    }
} 
