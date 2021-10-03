<?php
declare(strict_types=1);

namespace App\Application\Actions\Container;

use App\Domain\Container\Container;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteContainerAction extends ContainerAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $this->logger->info("Try to delete container", $this->args['_id']);
        $count = $this->containerRepository->remove(['_id'=>$this->args['_id']]);
        return $this->respondWithData(['deleted' => $count]);
    }
}
