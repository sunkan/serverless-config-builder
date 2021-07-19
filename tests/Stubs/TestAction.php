<?php declare(strict_types=1);

namespace Tests\Stubs;

use Sunkan\ServerlessConfigBuilder\Attributes\ServerlessAuthorizer;
use Sunkan\ServerlessConfigBuilder\Attributes\ServerlessEnvironment;
use Sunkan\ServerlessConfigBuilder\Attributes\ServerlessRoute;
use Sunkan\ServerlessConfigBuilder\Attributes\ServerlessTag;

#[ServerlessTag('service:group', 'test')]
#[ServerlessTag('service:name', 'test-action')]
#[ServerlessEnvironment('DB', 'test_db')]
#[ServerlessRoute(ServerlessRoute::GET, '/test')]
#[ServerlessAuthorizer('authorizer-handler')]
final class TestAction
{

}
