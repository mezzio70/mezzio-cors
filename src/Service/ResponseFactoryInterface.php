<?php

declare(strict_types=1);

namespace Mezzio\Cors\Service;

use Mezzio\Cors\Configuration\ConfigurationInterface;
use Psr\Http\Message\ResponseInterface;

interface ResponseFactoryInterface
{
    /**
     * Creates a preflight response.
     * @param string $origin
     * @param \Mezzio\Cors\Configuration\ConfigurationInterface $config
     */
    public function preflight($origin, $config): ResponseInterface;

    /**
     * @param string $origin
     */
    public function unauthorized($origin): ResponseInterface;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param string $origin
     * @param \Mezzio\Cors\Configuration\ConfigurationInterface $config
     */
    public function cors(
        $response,
        $origin,
        $config
    ): ResponseInterface;
}
