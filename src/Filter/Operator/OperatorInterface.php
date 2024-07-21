<?php
namespace Clientedigital\Pipefy\Filter\Operator;

use Clientedigital\Pipefy\Entity\EntityInterface;
use \StdClass;

interface OperatorInterface 
{
    public function evaluate(EntityInterface $item, $field, $value);
 
} 
