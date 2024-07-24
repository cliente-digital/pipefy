<?php
namespace Clientedigital\Pipefy\Entity;
use StdClass;


class Label extends AbstractModel implements EntityInterface
{

    private array $newData = [];

    public function __construct(?StdClass $data=null)
    {
        parent::__construct($data);
        $this->name($this->name);
        $this->color($this->color);
    }


    public function name(string $name): void
    {
        $this->newData['NAME'] = $name;
    }

    public function color(string $colorName): void
    {
        $this->newData['COLOR'] = $colorName;
    }

    public function tableId(int $id): void
    {
        $this->newData['TABLEID'] = $name;
    }

    public function pipeId(int $id): void
    {
        $this->newData['PIPEID'] = $name;
    }

    public function __newData()
    {
        return $this->newData;
    }
}
