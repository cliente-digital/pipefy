<?php
namespace Clientedigital\Pipefy\Entity;
use StdClass;

abstract class  AbstractModel
{
    protected ?StdClass $data=null;

    public function __construct(?StdClass $data=null)
    {
        $this->data = $data;
    }

    public function reload(StdClass $data){
        $this->data = $data;
    } 

    public function loaded()
    {
       return !is_null($this->data); 
    }

    public function __get($dataId=null) {
        if(!$this->loaded())
            throw new \Exception("No Readable Properties are set.");

        if(is_null($dataId))
            return $this->data;

        if(isset($this->data->$dataId))
            return $this->data->$dataId;

        foreach($this->data->fields as $field){
           if($dataId == $field->field->id){
                return $field->value;
            }
        }

        return null;
    }
}
