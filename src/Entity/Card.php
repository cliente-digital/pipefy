<?php
namespace Clientedigital\Pipefy\Entity;
use Clientedigital\Pipefy\Schema;
use Clientedigital\Pipefy\Schema\Data;
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
        'FIELDS' => null
    ];


    public function __construct(?StdClass $data=null)
    {
        parent::__construct($data);
        $this->newData['FIELDS'] = new Data\CollectionOf(Data\Type\AbstractType::class);
    }

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

    public function setField(string $name, $value)
    {
        $field = Schema::field($this->newData['PIPEID'], $name); 
        $field->value($value);
        $this->newData['FIELDS']->add($field);
    }

    public function addParentCardId(int $parentId)
    {
        $this->newData['PARENTIDS'][] = $parentId;
    }

    public function addAssigneeId(int $assigneeId)
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

    public function __newData(array $selectedFields =[])
    {
        $PARENTIDS = implode(", ", $this->newData['PARENTIDS']);
        $LABELIDS = implode(", ", $this->newData['LABELIDS']);
        $ASSIGNEEIDS = implode(", ", $this->newData['ASSIGNEEIDS']);
        $FIELDS = $this->newData['FIELDS'];

        $newData = $this->newData;
        $newData['LABELIDS'] = $LABELIDS;
        $newData['PARENTIDS'] = $PARENTIDS;
        $newData['ASSIGNEEIDS'] = $ASSIGNEEIDS;
        $newData['FIELDS'] = $FIELDS;
        
        $dataset = [];
        foreach($newData as $dataname => $datavalue){
            if(!is_null($datavalue) && $datavalue != "" && $datavalue != [])
                if($selectedFields ==[])
                    $dataset[$dataname] = $datavalue;
                if(in_array($dataname, $selectedFields))
                    $dataset[$dataname] = $datavalue;
        }
        
        return $dataset;
    }
}
