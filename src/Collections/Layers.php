<?php declare(strict_types=1);

namespace Sunkan\ServerlessConfigBuilder\Collections;

use Sunkan\ServerlessConfigBuilder\Attributes\ServerlessLayer;

/**
 * @implements \IteratorAggregate<ServerlessLayer>
 */
final class Layers implements \IteratorAggregate, \Countable
{
    /** @var ServerlessLayer[] */
    private array $layers = [];

    /**
     * @return array<int, string>
     */
    public function getArrayCopy(): array
    {
        $data = [];
        foreach ($this->layers as $layer) {
            $data[] = $layer->name;
        }
        return $data;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->layers);
    }

    public function add(ServerlessLayer $layer): void
    {
        $this->layers[] = $layer;
    }

    public function count(): int
    {
        return \count($this->layers);
    }
}
