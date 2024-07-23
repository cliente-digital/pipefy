<?php
namespace Clientedigital\Pipefy\Entity;

class Pipe extends AbstractModel implements EntityInterface
{
    private array $newData = [];

    public function name(string $name): void
    {
        $this->newData['NAME'] = $name;
    }

    public function anyoneCanCreateCard(bool $anyone=true): void
    {
        $this->newData['ANYONECANCREATECARD'] = $anyone;
    }
    
    public function expirationTimeByUnit(string $unit): void
    {
        $units = ['minutes'=>60, 'hours'=>3600, 'day'=>86400];

        if (!in_array($unit, array_keys($units)))
            throw new \Exception("invalid TimeUnit {$unit}. valids are" . implode(", ", array_keys($units)));

        $this->newData['EXPIRATIONTIMEBYUNIT'] = $units[$unit];
    }

    public function expirationUnit(int $unit): void
    {
        $this->newData['EXPIRATIONUNIT'] = $unit;
    }
 
    public function icon(string $icon): void
    {
	    $icons = [
            'airplane', 'at', 'axe', 'badge', 'bag', 'boat', 'briefing', 'bug', 'bullhorn', 
            'calendar', 'cart', 'cat', 'chart-zoom', 'chart2', 'chat', 'check', 'checklist', 
            'compass', 'contract',  'dog',  'eiffel', 'emo', 'finish-flag', 'flame', 'frame', 
            'frog', 'game', 'github', 'globe', 'growth',  'hr-process', 'hr-requests',  'ice',
            'juice', 'lamp', 'lemonade',  'liberty', 'like',  'mac', 'magic', 'map',  'message',
            'mkt-requests', 'money', 'onboarding', 'pacman', 'pacman1', 'payable', 'phone', 'pipefy',
            'pizza', 'planet', 'plug', 'receivables', 'receive', 'recruitment-requests', 'reload', 
            'rocket', 'sales', 'skull', 'snow-flake', 'star',  'target', 'task', 'task-management',
            'trophy', 'underwear'
        ];

        if (!in_array($unit, $icons))
            throw new \Exception("invalid Icon {$icon}. valids are" . implode(", ", $icons));

        $this->newData['ICON'] = $icon;
    }
 
    public function onlyAssigneesCanEditCards(bool $only=true): void
    {
        $this->newData['ONLYASSIGNEESCANEDITCARDS'] = $only;
    }
 
    public function onlyAdminCanRemoveCards(bool $only=true): void
    {
        $this->newData['ONLYADMINCANREMOVECARDS'] = $only;
    }

    public function isPublic(bool $public=true): void
    {
        $this->newData['PUBLIC'] = $public;
    }

    public function activePublicForm(bool $active=true): void
    {
        $this->newData['PUBLICFORM'] = $active;
    }

    public function titleFieldId(int $fieldId): void
    {
        $this->newdata['TITLEFIELDID'] = $fieldId;
    }
 
    public function color(string $color): void
    {
        $this->newdata['COLOR'] = $color;
    }
 
    public function noum(string $noum): void
    {
        $this->newdata['NOUM'] = $noun;
    }
 
    public function __newData()
    {
        return $this->newData;
    }

/*
    TODO
    public function preferences(bool $only=true): void
    {
        $this->newData['PREFERENCES'] = $only;
    }

    public function publicFormSettings(bool $only=true): void
    {
        $this->newData['PUBLICFORMSETTINGS'] = $only;
    }
*/ 


}
