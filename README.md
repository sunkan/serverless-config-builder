# Serverless Config Builder

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sunkan/serverless-config-builder.svg)](https://packagist.org/packages/sunkan/serverless-config-builder)
[![Software License](https://img.shields.io/github/license/sunkan/serverless-config-builder.svg)](LICENSE)
[![Build Status](https://github.com/sunkan/serverless-config-builder/actions/workflows/unit-test.yml/badge.svg)](https://github.com/sunkan/serverless-config-builder/actions/workflows/unit-test.yml)
[![Coverage Status](https://coveralls.io/repos/github/sunkan/serverless-config-builder/badge.svg?branch=main)](https://coveralls.io/github/sunkan/serverless-config-builder?branch=main)

## Installation

```
$ composer require sunkan/serverless-config-builder
```

## Usage

```php
use Sunkan\ServerlessConfigBuilder\Builder;
use Sunkan\ServerlessConfigBuilder\Entities\HttpFunction;
use Sunkan\ServerlessConfigBuilder\Entities\SqsFunction;

$builder = Builder::fromTemplate(__DIR__ . '/resources/serverless.template.yml');
$builder->addFunction(HttpFunction::fromObject(TestAction::class));
$sqsFunction = new SqsFunction(
'sqs-handler',
    TestAction::class,
    'arn:to:queue',
);
$builder->addFunction($sqsFunction);
$builder->save('serverless.yml');
```
