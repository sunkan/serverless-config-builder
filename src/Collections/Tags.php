<?php declare(strict_types=1);

namespace Sunkan\ServerlessConfigBuilder\Collections;

use IteratorAggregate;
use Sunkan\ServerlessConfigBuilder\Attributes\ServerlessTag;

/**
 * @implements IteratorAggregate<ServerlessTag>
 */
final class Tags implements IteratorAggregate, \Countable
{
    /** @var ServerlessTag[] */
    private array $tags = [];

    /**
     * @return array<string, string>
     */
    public function getArrayCopy(): array
    {
        $data = [];
        foreach ($this->tags as $tag) {
            $data[$tag->key] = $tag->value;
        }
        return $data;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->tags);
    }

    public function add(ServerlessTag $tag): void
    {
        $this->tags[] = $tag;
    }

    public function count(): int
    {
        return count($this->tags);
    }
}
