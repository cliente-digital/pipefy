<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;
use \stdclass;

abstract class AbstractType 
{
    private stdclass $definition;
    public function __construct(stdclass $definition)
    {
        $this->definition = $definition;
    }

    public function id(): string
    {
        return $this->definition->id;
    }

    protected function label(): string
    {
        return $this->definition->label;
    }

    protected function type(): string
    {
        return $this->definition->type;
    }

    protected function options(): array 
    {
        return $this->definition->options;
    }

    protected function editable(): bool
    {
        return $this->definition->editable;
    }

    protected function deleted(): bool
    {
        return $this->definition->deleted;
    }

    protected function required(): bool
    {
        return $this->definition->required;
    }



}
