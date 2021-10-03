<?php
declare(strict_types=1);

namespace App\Application\Actions\Container;

use App\Domain\Container\Container;
use Psr\Http\Message\ResponseInterface as Response;

class CreateContainerAction extends ContainerAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = (array)json_decode($this->request->getBody()->getContents());

        var_dump($data);
        $this->logger->info("Try to create container",$data);

        unset($data['_id']);

        $container = new Container(...$data);

        $container = $this->containerRepository->insert($container);

        return $this->respondWithData($container);
    }
}
