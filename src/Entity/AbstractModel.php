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

    public function allData(){
        if(!$this->loaded())
            throw new \Exception("No Readable Properties are set.");

        return $this->data;
    }

    public function __get($dataId) {
        if(!$this->loaded())
            throw new \Exception("No Readable Properties are set.");

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
