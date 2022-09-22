<?php

declare(strict_types=1);

namespace Mezzio\Cors\Configuration;

use Mezzio\Cors\Service\CorsMetadata;
use Webmozart\Assert\Assert;

use function array_unique;
use function sort;

use const SORT_ASC;
use const SORT_STRING;

final class RouteConfiguration extends AbstractConfiguration implements RouteConfigurationInterface
{
    /**
     * @var bool
     */
    private $overridesProjectConfiguration = true;

    /**
     * @var bool
     */
    private $explicit = false;

    /**
     * @param bool $overridesProjectConfiguration
     * @return void
     */
    public function setOverridesProjectConfiguration($overridesProjectConfiguration)
    {
        $this->overridesProjectConfiguration = $overridesProjectConfiguration;
    }

    /**
     * MUST return true if the projects config may be overriden. If it returns false, the project config will get
     * merged.
     */
    public function overridesProjectConfiguration(): bool
    {
        return $this->overridesProjectConfiguration;
    }

    /**
     * @inheritDoc
     */
    public function explicit(): bool
    {
        return $this->explicit;
    }

    /**
     * @param bool $explicit
     * @return void
     */
    public function setExplicit($explicit)
    {
        $this->explicit = $explicit;
    }

    /**
     * @param \Mezzio\Cors\Configuration\ConfigurationInterface $configuration
     */
    public function mergeWithConfiguration($configuration): RouteConfigurationInterface
    {
        if ($configuration === $this) {
            return $configuration;
        }

        $instance = clone $this;

        if (! $instance->credentialsAllowed()) {
            $instance->setCredentialsAllowed($configuration->credentialsAllowed());
        }

        if ($instance->allowedMaxAge() === ConfigurationInterface::PREFLIGHT_CACHE_DISABLED) {
            $instance->setAllowedMaxAge($configuration->allowedMaxAge());
        }
        $item0Unpacked = $configuration->allowedHeaders();
        $item1Unpacked = $instance->allowedHeaders();

        $instance->setAllowedHeaders(array_merge($item0Unpacked, $item1Unpacked));
        $item2Unpacked = $configuration->allowedOrigins();
        $item3Unpacked = $instance->allowedOrigins();
        $instance->setAllowedOrigins(array_merge($item2Unpacked, $item3Unpacked));
        $item4Unpacked = $configuration->exposedHeaders();
        $item4Unpacked = $instance->exposedHeaders();
        $instance->setExposedHeaders(array_merge($item4Unpacked, $item4Unpacked));

        return $instance->withRequestMethods($configuration->allowedMethods());
    }

    /**
     * Should merge the request methods.
     *
     * @psalm-param list<string> $methods
     * @param mixed[] $methods
     */
    public function withRequestMethods($methods): RouteConfigurationInterface
    {
        $item4Unpacked = $this->allowedMethods;
        $methods = $this->normalizeRequestMethods(array_merge($item4Unpacked, $methods));

        $instance                 = clone $this;
        $instance->allowedMethods = $methods;

        return $instance;
    }

    /**
     * @param array<int|string,string> $methods
     * @psalm-return list<string>
     */
    private function normalizeRequestMethods(array $methods): array
    {
        Assert::allOneOf($methods, CorsMetadata::ALLOWED_REQUEST_METHODS);

        $methods = array_unique($methods);
        sort($methods, SORT_ASC | SORT_STRING);

        return $methods;
    }
}
