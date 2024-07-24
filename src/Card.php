<?php
namespace Clientedigital\Pipefy;
use Clientedigital\Pipefy\Graphql\Card\One;
use Clientedigital\Pipefy\Graphql\Label;
use Clientedigital\Pipefy\Entity;

class Card 
{
    private int $id;
    private ?Entity\Card $card=null;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function load()
    {
        return (new One($this->id))->get(); 
    }

    public function get()
    {
        if(is_null($this->card))
            $this->card = $this->load();
        return $this->card;
    }

    public function labels()
    {
        return (new Label\All())->fromCard($this->id); 
    }


} 
