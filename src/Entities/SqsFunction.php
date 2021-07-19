<?php declare(strict_types=1);

namespace Sunkan\ServerlessConfigBuilder\Entities;

use Sunkan\ServerlessConfigBuilder\Collections\EnvironmentVariables;
use Sunkan\ServerlessConfigBuilder\Collections\Layers;
use Sunkan\ServerlessConfigBuilder\Collections\Tags;

final class SqsFunction extends AbstractFunction
{
    public function __construct(
        string $name,
        string $handler,
        private string $sqsArn,
        ?Layers $layers = null,
        ?Tags $tags = null,
        ?EnvironmentVariables $environmentVariables = null,
    ) {
        parent::__construct($name, $handler, $layers, $tags, $environmentVariables);
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array{handler: string, events: array<int, array{sqs: string}>, layers?: array<int, string>, tags?: array<string, string>}
     */
    public function getArrayCopy(): array
    {
        $data = parent::getArrayCopy();
        $data['events'][] = ['sqs' => $this->sqsArn];
        return $data;
    }
}
