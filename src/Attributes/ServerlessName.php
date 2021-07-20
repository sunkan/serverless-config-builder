<?php declare(strict_types=1);

namespace Sunkan\ServerlessConfigBuilder\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS)]
final class ServerlessName
{
    public function __construct(
        public string $name,
    ) {}
}
