<?php
namespace Clientedigital\Pipefy\Graphql;
use \stdclass;

class Bulk 
{
    private static ?Bulk\Paginator $paginator= null; 

    public static function init(int $pageSize = CLIENTE_DIGITAL_BULK_PAGE_SIZE)
    {
        self::$paginator = new Bulk\Paginator($pageSize);
    }

    public static function pageSize()
    {
        if(is_null(self::$paginator))
            throw new \Exception("Bulk need be initialized.");
        return self::$paginator->info()->pageSize;
    }

    public static function add(GQL $gql) :int
    {
        if(is_null(self::$paginator))
            throw new \Exception("Bulk need be initialized.");
        return self::$paginator->add($gql);
    }

    public static function destroy(){
        self::$paginator = null;
    }

    public static function remove(int $gqlId): bool
    {
        self::$paginator->remove($gqlId);
    }

    public static function paginate(): \Iterator
    {
        $pages = self::$paginator->paginate();
        foreach($pages as $page){
            yield $page;
        }
    }

    public static function info(): stdclass
    {
        return self::$paginator->info();
    }
} 
