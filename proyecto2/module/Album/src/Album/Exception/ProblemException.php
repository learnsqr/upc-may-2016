<?php

namespace Album\Exception;

/**
 * Could extends from Zend\Stdlib\Exception
 *
 * BadMethodCallException
 * DomainException
 * ExtensionNotLoadedException
 * InvalidArgumentException
 * InvalidCallbackException
 * LogicException
 * RuntimeException
 *
 * or from ZF\ApiProblem\Exception
 *
 * DomainException
 *
 */

use \DomainException;

class ProblemException extends DomainException
{
    
    public function __construct()
    {
        echo "kaka";
        parent::__construct();
    }
    
    
}