<?php
declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\Container\Container;
use Tests\TestCase;

class ContainerTest extends TestCase
{
    public function testGetters()
    {
        $container = new Container( "domain.com",'container', 'docker-image:tag', ['option1'=>'optionValue1'],'command', "1");

        $this->assertEquals("1", $container->getId());
        $this->assertEquals("domain.com", $container->getDomain());
        $this->assertEquals('container', $container->getName());
        $this->assertEquals('docker-image:tag', $container->getImage());
        $this->assertEquals(['option1'=>'optionValue1'], $container->getOptions());
        $this->assertEquals('command', $container->getCommand());

        $container->setStatus('unkown_status');
        $this->assertEquals(Container::STATUS_PENDING, $container->getStatus());

        $container->setStatus(Container::STATUS_PENDING);
        $this->assertEquals(Container::STATUS_PENDING, $container->getStatus());

        $container->setStatus(Container::STATUS_STARTED);
        $this->assertEquals(Container::STATUS_STARTED, $container->getStatus());
    }

    public function testJsonSerialize()
    {
        $user = new Container( "domain.com",'container', 'docker-image:tag', ['option1'=>'optionValue1'],'command', "1");

        $expectedPayload = json_encode([
            '_id' => "1",
            'domain' => "domain.com",
            'name' => 'container',
            'image' => 'docker-image:tag',
            'options' => ['option1'=>'optionValue1'],
            'command' => 'command',
            'status' => Container::STATUS_PENDING,
        ]);

        $this->assertEquals($expectedPayload, json_encode($user));
    }
}
