<?php
namespace Clientedigital\Pipefy;
use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Graphql\Card\All;
use Clientedigital\Pipefy\Filter;

class Cards
{
    use GraphQL;

    private int $pipeId=0;
    private array $cards = [];

    public function __construct(int $pipeId)
    {
        $this->pipeId = $pipeId;
        $this->filter = new Filter\Cards();
    }

    private function load()
    {
        $allcards= new All($this->pipeId, $this->filter->script());
        $this->cards = $allcards->get();
    }

    public function get(?Filter\Cards $filter=null){
        $this->load();
        foreach($this->cards as $card){
            if(!is_null($filter))
                yield;
            if(!$filter->check($card))
                continue;
            yield $card;
        }
    }
} 
