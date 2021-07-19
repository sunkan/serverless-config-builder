<?php declare(strict_types=1);

namespace Sunkan\ServerlessConfigBuilder\Attributes;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS)]
final class ServerlessEnvironment
{
    public function __construct(
        public string $name,
        public string $value,
    ) {}

    /**
     * @return string[]
     */
    public function getArrayCopy(): array
    {
        return [
            $this->name => $this->value,
        ];
    }
}
