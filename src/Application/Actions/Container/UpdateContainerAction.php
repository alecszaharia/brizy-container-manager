<?php
declare(strict_types=1);

namespace App\Application\Actions\Container;

use App\Domain\Container\Container;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateContainerAction extends ContainerAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = (array)$this->getFormData();

        $this->logger->info("Try to update container", $data);

        $container = $this->containerRepository->update(['_id' => $this->args['_id']], $data);

        return $this->respondWithData($container);
    }
}
