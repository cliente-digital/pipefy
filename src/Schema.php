<?php
namespace Clientedigital\Pipefy;

use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Schema\Data\Mapper;

class Schema
{
    use GraphQL;
    private static $cache = null;

    public function build(): void
    {
        Pipefy::useCache(true);
        $gql = $this->getGQL("schema.build");
        $schema = $this->request($gql);
        $this->setCache($gql->info()->cacheId, $schema);
        Pipefy::useCache(false);
    }
    public function report(): string
    {
        $this->getCache($this->getGQL("schema.build")->info()->cacheId);
    }

    public static function field(int $pipeId, string $fieldName){
        if(is_null(self::$cache)) {
            $schema = new Schema();
            self::$cache = $schema->getCache($schema->getGQL("schema.build")->info()->cacheId);
        }

        $pipe = self::getPipeSchema($pipeId);
        if(is_null($pipe))
            throw new \Exception("Pipe {$pipeId} don't exist at the schema.");

        $fieldDefinition = self::getFieldSchema($pipe, $fieldName);
        if(is_null($fieldDefinition))
            throw new \Exception("Field {$fieldName} don't exist at the schema.");
        return (new Mapper())->load($fieldDefinition);
    }

    private static function getPipeSchema(int $pipeId){
        $organizations = self::$cache->data->organizations;
        foreach($organizations as $organization){
            foreach($organization->pipes as $pipe){
                if($pipe->id == $pipeId)
                    return $pipe;
            }
        }
    }

    private static function getFieldSchema($pipe, $fieldName){
        foreach($pipe->start_form_fields as $field){
            if($field->id == $fieldName)
                return $field;
        }
        foreach($pipe->phases as $phase){
            foreach($phase->fields as $field){
                if($field->id == $fieldName)
                    return $field;
            }
        }

    }
}
