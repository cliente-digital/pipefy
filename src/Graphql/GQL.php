<?php
namespace Clientedigital\Pipefy\Graphql;

Class GQL implements GQLInterface{
    
    private array $property = []; 
    private string $scriptname;
    private string $rawScript;
    private ?int $id=null;

    private const REQUIRED_PROPERTY = "_R\.FNAME_";
    private const NOTREQUIRED_PROPERTY = "_FNAME_";
    private const PROPERTY_PATTERN = "_(R\.){0,1}([A-Z]*)_";

    public function __construct(string $scriptname)
    {
       $this->scriptname = $scriptname; 

       $path = CLIENTEDIGITAL_PIPEFY_GRAPHQL_DIR . 
            str_replace("-", DIRECTORY_SEPARATOR, $this->scriptname) . ".gql";

        if(!is_file($path))
            throw new \Exception("GQL script: {$this->scriptname} not found");

        $this->rawScript = file_get_contents($path);
   }

    public function id(?int $id=null)
    {
        if(is_null($id))
            return $this->id;
        $this->id = $id;
    }

    public function script(): string
    {
        $info = $this->info();
        $gqlscript = $this->rawScript();
        foreach($this->property as $propName => $propValue){
            $gqlscript = str_replace("_{$propName}_", $propValue, $gqlscript);
        }
        $this->check($info, $gqlscript);

        return $this->sanitize($gqlscript);
    }

    public function rawScript(): string
    {
        return trim($this->rawScript);
    }
  
    public function set(string $propName, string $propValue): void
    {
        $gqlscript = $this->rawScript();
        if(
            preg_match("/_R.{$propName}_/", $gqlscript)!==1 and
            preg_match("/_{$propName}_/", $gqlscript)!==1
        ){
            throw new \Exception("Property {$propName} dont exist in gql {$this->scriptname}"); 
        }

        $this->property[$propName] = $propValue; 
    }

    public function info()
    {
        $rawScript = $this->rawScript();
        $ismutation = preg_match("/mutation/", $rawScript) ===1;
        preg_match_all("/".self::PROPERTY_PATTERN."/", $rawScript, $matches);
        $fields = $matches[2];
        foreach($fields as $idx => $field){
            $fields[$idx] = $this->property($field);
        }
        $info = new \stdclass;
        $info->name = $this->scriptname;
        $info->kind = ($ismutation)?"mutation":"query";
        $info->fields = $fields;
        $info->script = $rawScript;
        return $info;
    }
    
    public function property($propName)
    {
        $rFieldPattern = str_replace("FNAME", $propName, self::REQUIRED_PROPERTY); 
        $fieldPattern = str_replace("FNAME", $propName, self::NOTREQUIRED_PROPERTY); 
        $isRequired = preg_match("/{$rFieldPattern}/", $this->rawScript()) === 1; 
        $isnotRequerid = preg_match("/{$fieldPattern}/", $this->rawScript()) === 1;

        $exists = ($isRequired or $isnotRequerid);
        $required = ($exists)? $isRequired: null;
        $type = null;

        if($exists){
            $stringPattern = ($isRequired)?"\"{$rFieldPattern}\"":"\"{$fieldPattern}\"";
            $type = (preg_match("/{$stringPattern}/", $this->rawScript()) === 1)
                ? "string" : "int";
        }

        $info = new \stdclass;
        $info->name = $propName;
        $info->exists = $exists;
        $info->required = $isRequired;
        $info->type = $type;

        return $info;
    } 

    private function sanitize(string $script): string
    {
        $lines = explode("\n", $script);
        $clearLines = []; 
        foreach($lines as $line){
             if(!preg_match("/_(R\.){0,1}([A-Z]*)_/", $line))
                $clearLines[] = $line;
        }
        $gqlscript = implode(" ", $clearLines);
        $gqlscript = str_replace(["\t"], " " , $gqlscript);
        $gqlscript = str_replace(['"'], "\\\"" , $gqlscript);

        return trim($gqlscript);
    }

    private function check(\stdclass $info, string $gqlscript)
    {
        foreach($info->fields  as $field){
            if(preg_match("/_R.{$field->name}_/", $gqlscript)===1)
                throw new \Exception("Required Field not set: {$field->name}");
        }
    }
}
