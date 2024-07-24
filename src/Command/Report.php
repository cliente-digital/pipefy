<?php
namespace Clientedigital\Pipefy\Command;

class Report{

    public function exec(array $args)
    {
        if(count($args)<2)
        {
            $this->help();
            return 0;
        }

        array_shift($args);

        if(count($args) == 0)
            return $this->help();

        $cmd = array_shift($args);

        $params = $args; 

        if($cmd== 'schema')
            return $this->schema(...$params);
        return 1;
    }
    private function help()
    {
        echo 
    "pipefy:report help
        pipefy:report schema 
            gera um relatorio do schema dos dados de sua organização.
    \n";
        return 0;
    }

    private function schema()
    {
        $schema = new \Clientedigital\Pipefy\Report\Schema();
        echo $schema->report() . PHP_EOL;
        return 0;
    }
}


