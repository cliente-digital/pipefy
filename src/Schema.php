<?php
use Clientedigital\Pipefy\Graphql\GraphQL;
class Schema
{
    use GraphQL;

    public function build(): void
    {
        $schema = $this->request( 
            $this->getGQL("schema.build")->script()
        );
        $this->setCache("schema", $schema);
    }
    public function report(): string
    {
        $this->getCache("schema", $schema);
    }
}
