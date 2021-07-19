<?php declare(strict_types=1);

namespace Sunkan\ServerlessConfigBuilder\Entities;

use ReflectionClass;
use Sunkan\ServerlessConfigBuilder\Attributes\ServerlessAuthorizer;
use Sunkan\ServerlessConfigBuilder\Attributes\ServerlessCors;
use Sunkan\ServerlessConfigBuilder\Attributes\ServerlessEnvironment;
use Sunkan\ServerlessConfigBuilder\Attributes\ServerlessLayer;
use Sunkan\ServerlessConfigBuilder\Attributes\ServerlessRoute;
use Sunkan\ServerlessConfigBuilder\Attributes\ServerlessTag;
use Sunkan\ServerlessConfigBuilder\Collections\EnvironmentVariables;
use Sunkan\ServerlessConfigBuilder\Collections\Layers;
use Sunkan\ServerlessConfigBuilder\Collections\Tags;

final class HttpFunction extends AbstractFunction
{
    /**
     * @param object|class-string $object
     */
    public static function fromObject(
        object|string $object,
        ?string $name = null,
        ?string $method = null,
        ?string $path = null,
    ): self {
        $cors = true;
        $tags = new Tags();
        $layers = new Layers();
        $envs = new EnvironmentVariables();
        $authorizer = null;
        $handlerReflection = new ReflectionClass($object);
        foreach ($handlerReflection->getAttributes() as $attribute) {
            $attributeInstance = $attribute->newInstance();
            if ($attributeInstance instanceof ServerlessTag) {
                $tags->add($attributeInstance);
            }
            elseif ($attributeInstance instanceof ServerlessLayer) {
                $layers->add($attributeInstance);
            }
            elseif ($attributeInstance instanceof ServerlessEnvironment) {
                $envs->add($attributeInstance);
            }
            elseif ($attributeInstance instanceof ServerlessCors) {
                $cors = $attributeInstance->flag;
            }
            elseif ($attributeInstance instanceof ServerlessAuthorizer) {
                $authorizer = $attributeInstance;
            }
            elseif ($attributeInstance instanceof ServerlessRoute) {
                $method = $method ?? $attributeInstance->method;
                $path = $path ?? $attributeInstance->path;
            }
        }
        if (!$method || !$path) {
            throw new \BadMethodCallException('Missing path or method');
        }

        if (!$name) {
            $name = $handlerReflection->getShortName();
            if (str_ends_with($name, 'Action')) {
                $name = substr($name, 0, -6);
            }
            $name = strtolower((string)preg_replace('/(?<!^)[A-Z]/', '-$0', $name));
        }

        return new self(
            $name,
            $handlerReflection->getName(),
            $path,
            $method,
            $cors,
            $authorizer,
            $layers,
            $tags,
            $envs,
        );
    }

    public function __construct(
        string $name,
        string $handler,
        private string $method,
        private string $path,
        private bool $cors = true,
        private ?ServerlessAuthorizer $authorizer = null,
        ?Layers $layers = null,
        ?Tags $tags = null,
        ?EnvironmentVariables $environmentVariables = null,
    ) {
        parent::__construct($name, $handler, $layers, $tags, $environmentVariables);
    }

    /**
     * @return array{handler: string, events: array<int, array{http: mixed[]}>, layers?: array<int, string>, tags?: array<string, string>}
     */
    public function getArrayCopy(): array
    {
        $data = parent::getArrayCopy();
        $httpEvent = [
            'path' => $this->path,
            'method' => $this->method,
        ];
        if ($this->cors) {
            $httpEvent['cors'] = true;
        }
        if ($this->authorizer) {
            $httpEvent['authorizer'] = $this->authorizer->getArrayCopy();
        }
        $data['events'][] = ['http' => $httpEvent];
        return $data;
    }
}
