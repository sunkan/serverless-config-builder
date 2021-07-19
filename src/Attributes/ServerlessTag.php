<?php declare(strict_types=1);

namespace Sunkan\ServerlessConfigBuilder\Attributes;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS)]
final class ServerlessTag
{
    public function __construct(
        public string $key,
        public string $value,
    ) {}

    /**
     * @return string[]
     */
    public function getArrayCopy(): array
    {
        return [
            $this->key => $this->value,
        ];
    }
}
