<?php
namespace Clientedigital\Pipefy\Entity;
use \Datetime;
use \stdclass;

class Card extends AbstractModel implements EntityInterface
{
 
    private array $newData = [
        'PIPEID' =>  null,
        'ASSIGNEEIDS' => [],
        'ATTACHMENTS' => [],
        'DUEDATE' => null,
        'LABELIDS' => [],
        'PARENTIDS' => [],
        'PHASEID' => null,
        'TITLE'=> null,
        'FIELDS' => []
        
    ];

    public function pipeId(int $pipeId)
    {
        $this->newData['PIPEID'] = $pipeId;
    }

    public function title(string $title)
    {
        $this->newData['TITLE'] = $title;
    }

    public function phaseId(int $phaseId)
    {
        $this->newData['PHASEID'] = $phaseId;
    }

    public function dueDate(Datetime $duedate)
    {
        $this->newData['DUEDATE'] = $duedate->format(DATE_ATOM);
    }

    public function setField(string $id, $value)
    {
        $field = new stdclass;
        $field->field_id = $id;
        $field->field_value = $value;

        $this->newData['FIELDS'][] = $field;
    }


    public function addParentCardId(int $parentId)
    {
        $this->newData['PARENTIDS'][] = $parentId;
    }

    public function addAddigneeId(int $assigneeId)
    {
        $this->newData['ASSIGNEEIDS'][] = $assigneeId;
    }

    public function addAttachmentURL(string $attachmentUrl)
    {
        $this->newData['ATTACHMENTS'][] = $attachmentUrl;
    }


    public function addLabelId(int $labelId)
    {
        $this->newData['LABELIDS'][] = $labelId;
    }


    public function __newData()
    {
        $PARENTIDS = implode(", ", $this->newData['PARENTIDS']);
        $LABELIDS = implode(", ", $this->newData['LABELIDS']);
        $ASSIGNEEIDS = implode(", ", $this->newData['ASSIGNEEIDS']);
        $FIELDS = ($this->newData['FIELDS']!=[])?json_encode($this->newData['FIELDS']):[];
        $FIELDS = str_replace("\"field_id\"","field_id" , $FIELDS);
        $FIELDS = str_replace("\"field_value\"","field_value", $FIELDS);

        $newData = $this->newData;
        $newData['LABELIDS'] = $LABELIDS;
        $newData['PARENTIDS'] = $PARENTIDS;
        $newData['ASSIGNEEIDS'] = $ASSIGNEEIDS;
        $newData['FIELDS'] = $FIELDS;
        
        $dataset = [];
        foreach($newData as $dataname => $datavalue){
            if(!is_null($datavalue) && $datavalue != "" && $datavalue != [])
                $dataset[$dataname] = $datavalue;
        }
        return $dataset;
    }
}
