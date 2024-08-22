<?php
namespace Clientedigital\Pipefy;
use Clientedigital\Pipefy\Graphql\Card\One;
use Clientedigital\Pipefy\Graphql\Label;
use Clientedigital\Pipefy\Entity;
use Clientedigital\Pipefy\Filter;


class Card 
{
    private int $id;
    private ?Entity\Card $card=null;

    public const REMOVE= 0;
    public const ADD= 1;
    public const UPDATE= 2;

    /**
    * Each Card Instance point/ manipulate only one Card defined by constructor id.
    **/ 
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
    * Retrieve the entity of the card(id).
    **/

    private function reload(){
        if(is_null($this->card)) return $this->entity();
        return (new One($this->id))->get($this->card);
    }

    public function entity()
    {
        if(is_null($this->card))
            $this->card = (new One($this->id))->get();
        return $this->card;
    }

    /**
    * Retrieve the card labels. 
    **/
    public function labels(?Filter\Label $filter=null)
    {
        $labels = (new Label\All())->fromCard($this->id); 
        if(is_null($filter))
            return $labels;
        foreach($labels as $idx => $label){
            if(!$filter->check($label))
               unset($labels[$idx]); 
        }
        sort($labels);
        return $labels;
    }

    /**
    * Retrieve the card comments.
    **/
    public function comments()
    {
        return (new One($this->id))->comments(); 
    }

    public function updateFields(Entity\Card $card)
    {
         
        return (new One($this->id))
            ->updateFields($card); 
    }

    /**
    * Add and remove labels to the card.
    */
    public function updateLabels(Entity\label $label, int $op)
    {
        if(in_array($op, [self::REMOVE, self::ADD])){
            if(!$label->loaded())
                throw new \Exception("You Can Only Add or Remove Labels that Exist.");
            $result = match($op){
                self::REMOVE=>  (new One($this->id))->removeLabel($label, $this->entity()->labels),
                self::ADD=>  (new One($this->id))->addLabel($label, $this->entity()->labels)
            };
            $this->reload();
            return $result;
        }
        throw new \Exception("You Can Only Add or Remove Labels that Exist.");
    }

    /**
    * Add or remove a Comment to card.
    **/
    public function comment(Entity\Comment $comment, $op=1) 
    {
        if($op == self::ADD)
            return (new One($this->id))->comment($comment);
        if(!$comment->loaded())
            throw new \Exception("You Only can Remove Comments that Exist.");

        if($op == self::UPDATE)
            return (new One($this->id))->updateComment($comment); 

        return (new One($this->id))->removeComment($comment); 
    }
} 
