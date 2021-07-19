<?php declare(strict_types=1);

namespace Sunkan\ServerlessConfigBuilder\Entities;

interface FunctionInterface
{
    public function getName(): string;

    /**
     * @return mixed[]
     */
    public function getArrayCopy(): array;
}
