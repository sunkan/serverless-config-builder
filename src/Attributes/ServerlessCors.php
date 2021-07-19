<?php declare(strict_types=1);

namespace Sunkan\ServerlessConfigBuilder\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class ServerlessCors {
    public function __construct(
        public bool $flag = true,
    ) {}
}
