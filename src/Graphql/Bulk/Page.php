<?php
namespace Clientedigital\Pipefy\Graphql\Bulk;
use Clientedigital\Pipefy\Graphql\GQL;
use Clientedigital\Pipefy\Graphql\GQLInterface;
use \stdclass;
use \Datetime;


class Page implements GQLInterface
{
    private array $gqls= [];
    private int $id;
    public function __construct(int $pageId, array $gqls)
    {
        $this->id = $pageId;
        $this->gqls = $gqls;
    }

    public function id()
    {
        return $this->id;
    }

    public function size(): int
    {   
        return count($this->gqls);
    }

    public function script(): string
    {
        $scripts = [];
        foreach($this->gqls as $gql){
            $script = str_replace("mutation{", "", substr($gql->script(), 0, -1));
            $scripts[] = "pageitem{$gql->id()}: ".$script;
        }
        return "mutation:{ ".implode(" ", $scripts)."}";
    }

    public function rawScript(): string
    {
        $scripts = [];
        foreach($this->gqls as $gql){
            $scripts[] = "pageitem{$gql->id()}: ".$gql->rawScript();
        }
        return implode("\n", $scripts);
    }

    public function info()
    {
        $info = new stdclass;
        $info->pageId = $this->id;
        $info->size = count($this->gqls);
        return $info;
    }

} 
