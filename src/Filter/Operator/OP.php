<?php
namespace Clientedigital\Pipefy\Filter\Operator;

Enum OP: string{
    case EQ   = '=';
    case NEQ  = '=!';
    case IN   = '<-';
    case NIN  = '<-!';
    case GT   = '>';
    case GTE  = '>=';
    case LT   = '<';
    case LTE  = '<=';
}

