<?php
namespace Clientedigital\Pipefy\Filter;
use Clientedigital\Pipefy\Entity\EntityInterface;

interface FilterInterface
{
    public function __construct();
    public function by($field, $op, $value);
    public function script(): string;
    public function check(EntityInterface $item);
 
 
 
} 
