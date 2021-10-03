<?php
declare(strict_types=1);

namespace App\Application\Actions\Container;

use App\Domain\Container\Container;
use Psr\Http\Message\ResponseInterface as Response;

class ListContainerAction extends ContainerAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $criteria = $this->request->getQueryParams();

        $documents = $this->containerRepository->findBy($criteria);

        return $this->respondWithData($documents);
    }
}
