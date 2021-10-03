<?php
declare(strict_types=1);

namespace App\Domain\Container;

interface ContainerRepository
{
    /**
     * @param array $criteria
     *
     * @return array
     */
    public function findBy(array $criteria): array;

    /**
     * @param array $criteria
     */
    public function remove(array $criteria): int;

    /**
     * @param Container $container
     */
    public function insert(Container $container): Container;

    /**
     * @param $criteria
     * @param Container $container
     */
    public function update(array $criteria, array $data): int;
}
