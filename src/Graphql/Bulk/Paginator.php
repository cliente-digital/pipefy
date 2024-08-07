<?php
namespace Clientedigital\Pipefy\Graphql\Bulk;
use Clientedigital\Pipefy\Graphql\GQL;
use \stdclass;
use \Datetime;


class Paginator 
{
    private array $mutations = [];
    private ?string $timeofFirstGQL = null;
    private int $pageSize;

    public function __construct(int $pageSize=CLIENTE_DIGITAL_BULK_PAGE_SIZE)
    {
        if($pageSize < 1){
            throw new \Exception("Pagesize cannot be less than 1.");
        }
        $this->pageSize = $pageSize;
    }

    public function add(GQL $gql) :int
    {
        if($gql->info()->kind != 'mutation')
            throw new \Exception("Only mutations can be paginate.");

        if(count($this->mutations)==0)
            $this->timeofFirstGQL= (new DateTime())->format("U");

        $gql->script();
        $this->mutations[] = $gql;
        $gqlId = count($this->mutations) -1;
        $gql->id($gqlId);
        return $gqlId;
    }

    public function remove(int $gqlId): bool
    {
        if(
            !isset($this->mutations[$gqlId]) or 
            is_null($this->mutations[$gqlId])
        )
            throw new \Exception("GQL ID {$gqlId} dont exist or was deleted.");

        $this->mutations[$gqlId] = null;
        return true;
    }

    /** make instance a need so I make clear the intention */
    public function paginate(): array
    {
        $pages = array_chunk($this->mutations, $this->pageSize);
        foreach($pages as $idx=> $page){
            $pages[$idx] = new Page($idx, $page);
        }
        return $pages;
    }

    public function info(): stdclass
    {
        $info = new stdclass;
        $info->pageSize = $this->pageSize; 
        $info->timeOfFirstGQL = (is_null($this->timeofFirstGQL))? null : (new \Datetime)->setTimestamp($this->timeofFirstGQL);
        $info->pages = count($this->paginate()); 
        return $info;
    }
} 
