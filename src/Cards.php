<?php
namespace Clientedigital\Pipefy;
use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Graphql\Card\All;
use Clientedigital\Pipefy\Filter;

class Cards
{
    use GraphQL;

    private Pipefy $client;
    private int $pipeId=0;
    private array $cards = [];
    private Filter\FilterInterface $filter;

    public function __construct(int $pipeId)
    {
        $this->pipeId = $pipeId;
        $this->client = new Pipefy;
        $this->filter = new Filter\Cards();
    }

    private function load()
    {
        $allcards= new All($this->pipeId, $this->filter->script());
        $this->cards = $allcards->get();
    }

    public function get(){
        $this->load();
        foreach($this->cards as $card){
            if(!$this->filter->check($card))
                continue;
            yield $card;
        }
    }

    public function filter(Filter\Cards $filter)
    {
        $this->filter = $filter;
    }
} 
