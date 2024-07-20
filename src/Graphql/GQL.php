<?php
namespace Clientedigital\Pipefy\Graphql;

Class GQL{
    
    private array $property = []; 
    private string $scriptname;
    public function __construct(string $scriptname)
    {
       $this->scriptname = $scriptname; 
    }

    public function script(): string
    {
        $file = PIPEFY_GRAPHQL_DIR."{$this->scriptname}.gql";
        if(!is_file($file))
            throw new \Exception("GQL file {$this->scriptname} not found");

        $gqlscript = str_replace('"', '\\"', file_get_contents($file));  

        foreach($this->property as $propName => $propValue){
            $gqlscript = str_replace("_{$propName}_", $propValue, $gqlscript);
        }

        return $gqlscript;
    }
    
    public function set(string $propName, string $propValue): void
    {
        $this->property[$propName] = $propValue; 
    }
}
