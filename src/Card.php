<?php
namespace Clientedigital\Pipefy;
use Clientedigital\Pipefy\Graphql\Card\One;
use Clientedigital\Pipefy\Graphql\Label;
use Clientedigital\Pipefy\Entity;

class Card 
{
    private int $id;
    private ?Entity\Card $card=null;

    public const REMOVE= 0;
    public const ADD= 1;
    public const UPDATE= 2;

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

    public function comments()
    {
        return (new One($this->id))->comments(); 
    }

    public function comment(Entity\Comment $comment, $op=1)
    {
        if($op == self::ADD)
            return (new One($this->id))->comment($comment); 

        if(!$comment->found())
            throw new \Exception("You Only can Remove Comments that Exist.");

        if($op == self::UPDATE)
            return (new One($this->id))->updateComment($comment); 

        return (new One($this->id))->removeComment($comment); 
        
    }

    public function modifyLabels(Entity\label $label, int $op)
    {
        if(in_array($op, [self::REMOVE, self::ADD])){
            if(!$label->found())
                throw new \Exception("You Can Only Add or Remove Labels that Exist.");
            $result = match($op){
                self::REMOVE=>  (new One($this->id))->removeLabel($label, $this->get()->labels),
                self::ADD=>  (new One($this->id))->addLabel($label, $this->get()->labels)
            };
            return $result;
        }
        throw new \Exception("You Can Only Add or Remove Labels that Exist.");
            
    }

} 
