<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Container;

use App\Application\Actions\ActionPayload;
use App\Domain\Container\Container;
use App\Domain\Container\ContainerRepository;
use Prophecy\Argument;
use Slim\Psr7\Environment;
use Slim\Psr7\Request;
use Tests\TestCase;

class CreateContainerActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $containerEntity = new Container( "domain.com",'container', 'docker-image:tag', ['option1'=>'optionValue1'],'command', "1");

        $containerRepositoryProphecy = $this->prophesize(ContainerRepository::class);
        $containerRepositoryProphecy
            ->insert(Argument::type(Container::class))
            ->willReturn([$containerEntity])
            ->shouldBeCalledOnce();

        $container->set(ContainerRepository::class, $containerRepositoryProphecy->reveal());

        $request = $this->createRequest('POST', '/containers');
        $request->getBody()->write(json_encode( [
            'domain' => "domain.com",
            'name' => 'container',
            'image' => 'docker-image:tag',
            'options' => ['option1'=>'optionValue1'],
            'command' => 'command',
            'status' => Container::STATUS_PENDING,
        ]));

        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$containerEntity]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
