<?php
namespace Clientedigital\Pipefy;
use Clientedigital\Pipefy\Graphql\GraphQL;
class Schema
{
    use GraphQL;

    private Pipefy $client;

    public function __construct()
    {
        $this->client = new Pipefy;
    }

    public function build(): void
    {
        $schema = $this->client->request( 
            $this->getGQL("schema.build")->script()
        );
        $this->setCache("schema", $schema);
    }
    public function report(): string
    {
        $this->getCache("schema", $schema);
    }
}