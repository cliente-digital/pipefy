<?php
namespace Clientedigital\Pipefy\Entity;

class Comment extends AbstractModel implements EntityInterface
{

    private array $newData = [];

    public function text(string $text)
    {
        $this->newData['TEXT'] = $text;
    }
    public function __newData()
    {
        return $this->newData;
    }


}
