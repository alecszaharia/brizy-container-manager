<?php
declare(strict_types=1);

namespace App\Application\Actions\Container;

use App\Domain\Container\Container;
use Psr\Http\Message\ResponseInterface as Response;

class RunContainerInstanceAction extends ContainerAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $uri = $this->request->getUri();

        $container = $this->containerRepository->findBy(['domain'=>$uri->getHost()]);

        return $this->respondWithData($container);
    }
}
