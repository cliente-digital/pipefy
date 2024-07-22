<?php
namespace Clientedigital\Pipefy\Entity;

class Org extends AbstractModel implements EntityInterface
{

    private array $newData = [];

    public function OnlyeAdminCanCreatePipes(bool $only=true): void
    {
        $this->newData['ONLYADMINCANCREATEPIPE'] = $only;
    }

    public function OnlyAdminCanInviteUsers(bool $only=true): void
    {
        $this->newData['ONLYADMINCANINVITEUSER'] = $only;
    }

    public function name(string $name): void
    {
        $this->newData['NAME'] = $name;
    }

    public function __newData()
    {
        return $this->newData;
    }
}
