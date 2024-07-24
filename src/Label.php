<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql\Label\One;
use Clientedigital\Pipefy\Entity;

class Label 
{

    public function update(Entity\Label $label)
    {
        return (new One())
            ->update($label); 
    }

    public function create(Entity\Label $label)
    {
        return (new One())
            ->create($label); 
    }
} 
