<?php
namespace Clientedigital\Pipefy\Entity;
use StdClass;

abstract class  AbstractModel
{
    protected ?StdClass $data=null;
    private $definition= null;

    public function __construct(?StdClass $data=null)
    {
        $this->data = $data;
    }

    public function found()
    {
       return !is_null($this->data); 
    }

    public function __get($dataId) {
        if(!$this->found())
            throw new \Exception("No Readable Properties are set.");

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
