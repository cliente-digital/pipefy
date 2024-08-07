<?php
namespace Clientedigital\Pipefy\Schema\Data;
use \stdclass;

class Mapper{
   private array $map = [
        'short_text' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\ShortText',
        'long_text' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\LongText',
        'statement' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\DynamicContent',
        'attachment' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\Attachment',
        'checklist_vertical' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\CheckList',
        'checklist_horizontal' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\CheckList',
        'assignee_select' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\Assignee',
        'date' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\Date',
        'datetime' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\DateTime',
        'due_date' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\DueDate',
        'label_select' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\Label',
        'email' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\Email',
        'phone' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\PhoneNumber',
        'select' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\Select',
        'radio_vertical' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\Select',
        'radio_horizontal' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\Select',
        'time' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\Time',
        'number' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\Number',
        'currency' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\Currency',
        'cpf' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\CPF',
        'RG' => '\\Clientedigital\\Pipefy\\Schema\Data\\Type\\RG'
    ];

   public function load(stdclass $fieldDefinition): Type\TypeInterface 
   {
        $type = $fieldDefinition->type;
        if(!isset($this->map[$type]))
            throw new \Exception("Data\Type {$type} is not available");
        $type = $this->map[$type];
        return new $type($fieldDefinition);
   }
}

