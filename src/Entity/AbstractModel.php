<?php
namespace Clientedigital\Pipefy\Entity;
use StdClass;

abstract class  AbstractModel
{
    protected StdClass $data;
    private $definition= null;
    private $searchResult = null;

    public function __construct(?StdClass $data=null, $searchResult=null)
    {
        if(is_null($data)){
            $this->data  = new StdClass;
            return;
        }
        $this->searchResult= $searchResult;
        $this->data = $data;
    }

    public function found()
    {
        return $this->searchResult;
    }

    public function __get($dataId) {
        if($this->found() === false)
            return throw new \Exception("Not Found.");

        if(isset($this->data->$dataId))
            return $this->data->$dataId;

        if(!isset($this->data))
            return null;

        foreach($this->data->fields as $field){
           if($dataId == $field->field->id)
                return $field->value;
        }

        return null;
    }

    /**
    * Carregar a definicao do do objeto baseado no type
    * essa definicao vem do cache.
    * - permite saber como manipular o objeto.
    * - definir estrategia de save/update.
    * - saber como filtrar (full scan | graphql schema suporte)
    */
    private function define(object $data)
    {
    
    }    
}
