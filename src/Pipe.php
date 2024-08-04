<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql\Pipe\One;
use Clientedigital\Pipefy\Graphql\Label;
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

    private function load(){
        return (new One($this->id))->get(); 
    }

    public function get()
    {
        if(is_null($this->pipe))
            $this->pipe = $this->load();
        return $this->pipe;
    }

    public function cards()
    {
        return new Cards($this->id);
    }

    public function update(Entity\Pipe $pipe)
    {
        $newValues = $resource->__newData();
        return (new One($this->id))
            ->updatePipe($newValues); 
    }

    public function labels(?Filter\Label $filter=null)
    {
        $labels =(new Label\All())->fromPipe($this->id); 
        if(is_null($filter))
            return $labels;
        foreach($labels as $idx => $label){
            if(!$filter->check($label))
               unset($labels[$idx]); 
        }
        sort($labels);
        return $labels;

    }

    public function createCard(Entity\Card $card)
    {
        $card->pipeId($this->id);
        $newValues = $card->__newData();
        return (new One($this->id))
            ->createCard($newValues); 
    }

    public function field(string $fieldName) //: DataType\TypeInterface
    {
        return Schema::field($this->id, $fieldName); 
    }
} 
