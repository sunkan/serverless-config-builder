<?php declare(strict_types=1);

namespace Tests;

use PHPStan\Testing\TestCase;
use Sunkan\ServerlessConfigBuilder\Builder;
use Sunkan\ServerlessConfigBuilder\Entities\HttpFunction;
use Sunkan\ServerlessConfigBuilder\Entities\SqsFunction;
use Tests\Stubs\TestAction;

final class BuilderWithTemplateTest extends TestCase
{
    public function testSimple(): void
    {
        $builder = Builder::fromTemplate(__DIR__ . '/resources/serverless.template.yml');
        $builder->addFunction(HttpFunction::fromObject(TestAction::class));
        $sqsFunction = new SqsFunction(
        'sqs-handler',
            TestAction::class,
            'arn:to:queue',
        );
        $builder->addFunction($sqsFunction);

        $this->assertSame(yaml_parse_file(__DIR__ . '/resources/serverless.test-result-1.yml'), $builder->generate());
    }
}
