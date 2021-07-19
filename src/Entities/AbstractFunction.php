<?php declare(strict_types=1);

namespace Sunkan\ServerlessConfigBuilder\Entities;

use Sunkan\ServerlessConfigBuilder\Collections\EnvironmentVariables;
use Sunkan\ServerlessConfigBuilder\Collections\Layers;
use Sunkan\ServerlessConfigBuilder\Collections\Tags;

abstract class AbstractFunction implements FunctionInterface
{
    public function __construct(
        protected string $name,
        protected string $handler,
        protected ?Layers $layers,
        protected ?Tags $tags,
        protected ?EnvironmentVariables $environmentVariables,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array{handler: string, events: mixed[], tags?: string[], layers?: string[], environment?: string[]}
     */
    public function getArrayCopy(): array
    {
        $data = [
            'handler' => $this->handler,
            'events' => [],
        ];
        if ($this->layers && count($this->layers)) {
            $data['layers'] = $this->layers->getArrayCopy();
        }
        if ($this->tags && count($this->tags)) {
            $data['tags'] = $this->tags->getArrayCopy();
        }
        if ($this->environmentVariables && count($this->environmentVariables)) {
            $data['environment'] = $this->environmentVariables->getArrayCopy();
        }
        return $data;
    }
}
