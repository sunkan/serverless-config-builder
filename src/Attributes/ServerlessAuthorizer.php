<?php declare(strict_types=1);

namespace Sunkan\ServerlessConfigBuilder\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class ServerlessAuthorizer
{
    public function __construct(
        public string $name,
        public int $cacheTtl = 300,
    ) {}

    /**
     * @return array{name: string, resultTtlInSeconds: int}
     */
    public function getArrayCopy(): array
    {
        return [
            'name' => $this->name,
            'resultTtlInSeconds' => $this->cacheTtl,
        ];
    }
}
