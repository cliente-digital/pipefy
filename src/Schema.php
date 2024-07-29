<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql\GraphQL;

class Schema
{
    use GraphQL;

    public function build(): void
    {
        Pipefy::useCache(true);
        $schema = $this->request( 
            $this->getGQL("schema.build")
        );
        $this->setCache("schema", $schema);
        Pipefy::useCache(false);
    }
    public function report(): string
    {
        $this->getCache("schema", $schema);
    }
}
