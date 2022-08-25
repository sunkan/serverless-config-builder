<?php declare(strict_types=1);

namespace Sunkan\ServerlessConfigBuilder\Attributes;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS)]
final class ServerlessRoute
{
    public const GET = 'GET';

    public function __construct(
        public string $method,
        public string $path,
    ) {}
}
