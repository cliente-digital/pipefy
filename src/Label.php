<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql\Label\One;
use Clientedigital\Pipefy\Entity;

class Label 
{

    public function update(Entity\EntityInterface $resource)
    {
        return (new One())
            ->update($resource); 
    }
} 
