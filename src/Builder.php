<?php declare(strict_types=1);

namespace Sunkan\ServerlessConfigBuilder;

use Sunkan\ServerlessConfigBuilder\Attributes\ServerlessEnvironment;
use Sunkan\ServerlessConfigBuilder\Attributes\ServerlessTag;
use Sunkan\ServerlessConfigBuilder\Collections\EnvironmentVariables;
use Sunkan\ServerlessConfigBuilder\Collections\Tags;
use Sunkan\ServerlessConfigBuilder\Entities\FunctionInterface;

final class Builder
{
    /** @var array<string, FunctionInterface> */
    private array $functions = [];
    private bool $haveTemplate = false;
    /** @var mixed[] */
    private array $templateContent = [];
    private Tags $tags;
    private EnvironmentVariables $envs;

    public static function fromTemplate(string $templateFile): self
    {
        $content = yaml_parse_file($templateFile);
        $self = new self($content['service']);
        $self->haveTemplate = true;
        $self->templateContent = $content;

        return $self;
    }

    public function __construct(
        private string $serviceName,
    ) {
        $this->tags = new Tags();
        $this->envs = new EnvironmentVariables();
    }

    public function addTag(ServerlessTag $tag): void
    {
        $this->tags->add($tag);
    }

    public function addEnvironment(ServerlessEnvironment $env): void
    {
        $this->envs->add($env);
    }

    public function addFunction(FunctionInterface $function): void
    {
        $this->functions[$function->getName()] = $function;
    }

    /**
     * @return mixed[]
     */
    public function generate(): array
    {
        if (count($this->envs)) {
            /** @var ServerlessEnvironment $env */
            foreach ($this->envs as $env) {
                $this->templateContent['provider']['environment'][$env->name] = $env->value;
            }
        }
        if (count($this->tags)) {
            $this->templateContent['provider']['tags'] = $this->tags->getArrayCopy();
        }

        foreach ($this->functions as $name => $function) {
            $this->templateContent['functions'][$name] = $function->getArrayCopy();
        }

        return $this->templateContent;
    }

    public function save(string $file): void
    {
        yaml_emit_file($file, $this->templateContent);
    }
}
