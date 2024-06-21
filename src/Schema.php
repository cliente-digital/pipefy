<?php
namespace Clientedigital\Pipefy;

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
        $schema = $this->client->exec( $this->getGQL("schema.build"));
        $this->setCache("schema", $schema);
    }
}
