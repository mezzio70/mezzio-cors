<?php

declare(strict_types=1);

namespace Mezzio\Cors\Service;

use Psr\Http\Message\ServerRequestInterface;

interface CorsInterface
{
    /**
     * Creates the cors metadata from
     * @param \Psr\Http\Message\ServerRequestInterface $request
     */
    public function metadata($request): CorsMetadata;

    /**
     * Should detect if a request is a request which needs CORS informations.
     * @param \Psr\Http\Message\ServerRequestInterface $request
     */
    public function isCorsRequest($request): bool;

    /**
     * Should detect if a request is a preflight request.
     * @param \Psr\Http\Message\ServerRequestInterface $request
     */
    public function isPreflightRequest($request): bool;
}
