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
    private bool $cached= Pipefy::UNCACHED;
    private array $cards = [];
    private Filter\FilterInterface $filter;

    public function __construct(int $pipeId, $cached = Pipefy::UNCACHED)
    {
        $this->pipeId = $pipeId;
        $this->client = new Pipefy;
        $this->cached = $cached;
        $this->filter = new Filter\Cards();
    }

    private function load()
    {
        if ($this->cached) {
            $all = $this->getCache("pipe-{$this->pipeId}.cards");
            $cards = [];
             foreach($all as $node){
                $cards[] = new Entity\Card($node->node);
            }
            $this->cards = $cards;
        } else {
            $allcards= new All($this->pipeId, $this->filter->script());
            $this->cards = $allcards->get();
        }
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
