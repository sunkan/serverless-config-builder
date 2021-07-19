<?php declare(strict_types=1);

namespace Sunkan\ServerlessConfigBuilder\Collections;

use Sunkan\ServerlessConfigBuilder\Attributes\ServerlessEnvironment;

/**
 * @implements \IteratorAggregate<ServerlessEnvironment>
 */
final class EnvironmentVariables implements \IteratorAggregate, \Countable
{
    /** @var ServerlessEnvironment[] */
    private array $envs = [];

    /**
     * @return array<string, string>
     */
    public function getArrayCopy(): array
    {
        $data = [];
        foreach ($this->envs as $env) {
            $data[$env->name] = $env->value;
        }
        return $data;
    }

    /**
     * @return \ArrayIterator<array-key, ServerlessEnvironment>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->envs);
    }

    public function add(ServerlessEnvironment $env): void
    {
        $this->envs[] = $env;
    }

    public function count(): int
    {
        return \count($this->envs);
    }
}
