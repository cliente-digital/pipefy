<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql;
use Clientedigital\Pipefy\Entity;
use Clientedigital\Pipefy\Filter;
use Clientedigital\Pipefy\Schema\Data\Type as DataType;


    
class Pipe 
{
    private int $id;
    private ?Entity\Pipe $pipe=null;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function id(): int{
        return $this->id;
    }

    public function suid(): string{
        $entity = $this->entity();
        return $entity->suid;
    }


    private function load(){
        return (new Graphql\Pipe\One($this->id))->get(); 
    }

    public function entity()
    {
        if(is_null($this->pipe))
            $this->pipe = $this->load();
        return $this->pipe;
    }

    public function update(Entity\Pipe $pipe)
    {
        if($this->id != $pipe->id)
            throw new \Exception("Entity($pipe->id) is not from this Pipe({$this->id}).");

        $newValues = $resource->__newData();
        return (new Graphql\Pipe\One($this->id))
            ->updatePipe($newValues); 
    }

    public function createCard(Entity\Card $card)
    {
        $card->pipeId($this->id);
        $newValues = $card->__newData();
        return (new Graphql\Pipe\One($this->id))
            ->createCard($newValues); 
    }

    public function field(string $fieldName): DataType\TypeInterface
    {
        return Schema::field($this->id, $fieldName); 
    }


    public function labels(?Filter\Label $filter=null)
    {
        $labels =(new Graphql\Label\All())->fromPipe($this->id); 
        if(is_null($filter))
            return $labels;
        foreach($labels as $idx => $label){
            if(!$filter->check($label))
               unset($labels[$idx]); 
        }
        sort($labels);

        return $labels;

    }

    public function cards(?Filter\Cards $filter=null)
    {

        $cards = new Graphql\Card\All($this->id);  

        if(!is_null($filter))
            $cards  = new Graphql\Card\All($this->id, $filter->script());

        $cards = $cards->get();         

        foreach($cards as $card){
            if(is_null($filter))
                yield $card;

            else if($filter->check($card))
                yield $card;
        }
    }

    public function card(int $id)
    {
        return new Card($id);
    }

} 
