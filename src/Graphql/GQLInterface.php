<?php
namespace Clientedigital\Pipefy\Graphql;

interface GQLInterface{
    
    public function script(): string;
    public function rawScript(): string;
    public function info();

}
