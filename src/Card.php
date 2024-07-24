<?php
namespace Clientedigital\Pipefy;
use Clientedigital\Pipefy\Graphql\Card\One;
use Clientedigital\Pipefy\Graphql\Label;
use Clientedigital\Pipefy\Entity;

class Card 
{
    private int $id;
    private ?Entity\Card $card=null;

    public const REMOVE_LABEL = 0;
    public const ADD_LABEL = 1;

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

    public function modifyLabels(Entity\label $label, int $op)
    {
        if(in_array($op, [self::REMOVE_LABEL, self::ADD_LABEL])){
            if(is_null($label) or !$label->found())
                throw new \Exception("You Can Only Add or Remove Labels that Exist.");
            $result = match($op){
                self::REMOVE_LABEL =>  (new One($this->id))->removeLabel($label, $this->get()->labels),
                self::ADD_LABEL    =>  (new One($this->id))->addLabel($label, $this->get()->labels)
            };
            return $result;
        }
        throw new \Exception("You Can Only Add or Remove Labels that Exist.");
            
    }

} 
