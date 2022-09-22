<?php

declare(strict_types=1);

namespace Mezzio\Cors\Exception;

use RuntimeException;
use Throwable;

use function sprintf;

final class InvalidOriginValueException extends RuntimeException implements ExceptionInterface
{
    /**
     * @param \Throwable|null $previous
     */
    private function __construct(string $message, $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    /**
     * @param string $origin
     * @param \Throwable $throwable
     */
    public static function fromThrowable($origin, $throwable): self
    {
        return new self(sprintf('Provided Origin "%s" is invalid.', $origin), $throwable);
    }
}
