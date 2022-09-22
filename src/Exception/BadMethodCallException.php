<?php

declare(strict_types=1);

namespace Mezzio\Cors\Exception;

use BadMethodCallException as BaseBadMethodCallException;

use function sprintf;

final class BadMethodCallException extends BaseBadMethodCallException implements ExceptionInterface
{
    /**
     * @param string $property
     * @param string $expectedSetterMethod
     */
    public static function fromMissingSetterMethod($property, $expectedSetterMethod): self
    {
        return new self(sprintf(
            'Missing setter method for property %s; expected setter %s',
            $property,
            $expectedSetterMethod
        ));
    }
}
