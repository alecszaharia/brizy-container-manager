<?php
declare(strict_types=1);

namespace App\Application\Actions\Container;


use App\Application\Actions\Action;
use App\Domain\Container\ContainerRepository as ContainerRepositoryInterface;
use Psr\Log\LoggerInterface;

abstract class ContainerAction extends Action
{
    protected ContainerRepositoryInterface $containerRepository;

    /**
     * @param LoggerInterface $logger
     * @param ContainerRepositoryInterface $containerRepository
     */
    public function __construct(LoggerInterface $logger,
        ContainerRepositoryInterface $containerRepository
    ) {
        parent::__construct($logger);
        $this->containerRepository = $containerRepository;
    }
}
