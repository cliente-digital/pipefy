<?php
namespace Clientedigital\Pipefy\Report;

use Clientedigital\Pipefy\Graphql\GraphQL;

class Schema
{
    use GraphQL;

    private array $organizations=['# Organizações'];
    private array $pipes=[];
    private array $startForms=['# Formulários Iniciais'];
    private array $phases=['# Fases'];
    private array $phasesFields = ['# Campos das Phases'];

    public function report(): string
    {
        $schema = $this->getCache("schema");
        $organizations = $schema->data->organizations;
        $this->organizations($organizations);

        return implode("\n", array_merge(
            ["Relatório Gerado em ".(new \Datetime())->format("d/m/Y H:i")."  \\".PHP_EOL],
            $this->organizations,
            $this->pipes,
        )); 
    }

    private function organizations(array $organizations){

        $report[] = "| ID | NAME | Criada EM|";
        $report[] = "|:--:|:----:|:--------:|";
        foreach($organizations as $organization){
            $report[] = "| {$organization->id}| {$organization->name} | {$organization->createdAt}|";
            $this->pipes($organization); 
        }

        $this->organizations= array_merge($this->organizations, $report);
    }

    private function pipes(object $organization)
    {
        $report= [''];
        $report= [''];
        $report[] = "## Pipes";
        $report[] = "| ID | NAME |";
        $report[] = "|:--:|:----:|"; 

       foreach($organization->pipes as $pipe) {
           $report[] = "| {$pipe->id}| {$pipe->name}|"; 
        }

       foreach($organization->pipes as $pipe) {
            $report[] = "### {$pipe->name}";
            $report = array_merge($report, $this->phases($pipe));
            $report = array_merge($report, $this->startForm($pipe));
        }


        $this->pipes = array_merge($this->pipes, $report);
    }

    private function startForm($pipe)
    {
        $pipes = [''];
        $pipes[] = "#### Formulário Inicial";

       foreach($pipe->start_form_fields as $field) {
            $options = implode(", ", $field->options);
            $deleted = $field->deleted==1 ? "SIM" : "NÃO";
            $editable = $field->editable==1 ? "SIM" : "NÃO";
            $required= $field->required==1 ? "SIM" : "NÃO";
            $deleted = $field->deleted==1 ? "SIM" : "NÃO";
            $type = $field->type;
           $pipes[] = 


                "Id: ```{$field->id}``` <br />
".
                "Rótulo: ```{$field->label}```

".
                "Tipo: ```{$type}```

".
                "Opções: ```{$options} ```

".
                "Editavel: ```{$editable}```

".
                "Obrigatório: ```{$required}```

".
                "Apagado: ```{$deleted}``` \

";
        }
        $pipes[] = "";

        return $pipes;
    }

    private function phases(Object $pipe)
    {
        $phases= [''];
        $phases[] = "#### Fases ";
        $phases[] = "| ID | Name| Index | Descrição|";
        $phases[] = "|:--:|:----:|:----:|:-------:|"; 
 
       foreach($pipe->phases as $phase) {
           $phases[] = "| {$phase->id}| {$phase->name}| {$phase->index}| {$phase->description}|"; 
        }
       foreach($pipe->phases as $phase) {
            $phases = array_merge($phases, $this->phaseFields($phase));
        }
 
         return $phases;
    }

    private function phaseFields(Object $phase)
    {
        $report= ["### Campos da Fase {$phase->name}"];
        if(count($phase->fields)==0)
        $report[] = " Essa fase não tem campos. \ 
";
        else {
       foreach($phase->fields as $field) {
            $options = implode(", ", $field->options);
            $deleted = $field->deleted==1 ? "SIM" : "NÃO";
            $editable = $field->editable==1 ? "SIM" : "NÃO";
            $required= $field->required==1 ? "SIM" : "NÃO";
            $deleted = $field->deleted==1 ? "SIM" : "NÃO";
            $type = $field->type;
           $report[] = 


                "Id: ```{$field->id}```

".
                "Rótulo: ```{$field->label}```

".
                "Tipo: ```{$type}```

".
                "Opções: ```{$options} ```

".
                "Editavel: ```{$editable}```

".
                "Obrigatório: ```{$required}```

".
                "Apagado: ```{$deleted}``` \

";
        }
        }
        return $report;
    }



}
