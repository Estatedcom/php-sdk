<?php

namespace Estated\Exceptions;

use Throwable;

/**
 * Class MissingParameterException
 *
 * @package Estated\Exceptions
 */
class MissingParameterException extends \Exception
{
    /**
     * Creates a new MissingParameterException object.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("MissingParameterException: Missing required parameters: " . $message . "\n", $code, $previous);
    }
}
