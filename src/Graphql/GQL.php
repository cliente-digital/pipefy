<?php
namespace Clientedigital\Pipefy\Graphql;

Class GQL{
    
    private array $property = []; 
    private string $scriptname;
    private string $rawScript;

    public function __construct(string $scriptname)
    {
       $this->scriptname = $scriptname; 

       $path = CLIENTEDIGITAL_PIPEFY_GRAPHQL_DIR . 
            str_replace("-", DIRECTORY_SEPARATOR, $this->scriptname) . ".gql";

        if(!is_file($path))
            throw new \Exception("GQL script: {$this->scriptname} not found");

        $this->rawScript = file_get_contents($path);
   }

    public function script(): string
    {
        $gqlscript = $this->rawScript();
        foreach($this->property as $propName => $propValue){
            $gqlscript = str_replace("_{$propName}_", $propValue, $gqlscript);
        }
        return $this->sanitize($gqlscript);
    }
    
    public function set(string $propName, string $propValue): void
    {
        $this->property[$propName] = $propValue; 
    }

    private function sanitize(string $script): string
    {
        $lines = explode("\n", $script);
        $clearLines = []; 
        foreach($lines as $line){
             if(!preg_match("/_[A-Z]_/", $line))
                $clearLines[] = $line;
        }
        $gqlscript = implode(" ", $clearLines);
        $gqlscript = str_replace(["\t"], " " , $gqlscript);
        $gqlscript = str_replace(['"'], "\\\"" , $gqlscript);

        return $gqlscript;
    }
    
    public function rawScript(): string
    {
        return $this->rawScript;
    }
}
