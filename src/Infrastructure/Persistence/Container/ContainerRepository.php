<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Container;

use App\Domain\Container\Container;
use App\Domain\Container\ContainerRepository as ContainerRepositoryInterface;
use App\Infrastructure\Persistence\Container\MongoLiteAware;

class ContainerRepository extends MongoLiteAware implements ContainerRepositoryInterface
{
    protected function getCollectionName()
    {
        return 'containers';
    }

    /**
     * @param int $id
     *
     * @return array<Container>
     * @throws \App\Infrastructure\InfrastructureException\InvalidMongoLiteCollectionException
     * @throws \App\Infrastructure\InfrastructureException\InvalidMongoLiteDatabaseException
     */
    public function findBy(array $criteria): array
    {
        $documents = $this->getCollection()->find($criteria);

        $result    = [];
        foreach ($documents as $document) {
            $result[] = new Container(...$document);
        }

        return $result;
    }

    /**
     * @param array $criteria
     *
     * @throws \App\Infrastructure\InfrastructureException\InvalidMongoLiteCollectionException
     * @throws \App\Infrastructure\InfrastructureException\InvalidMongoLiteDatabaseException
     */
    public function remove(array $criteria): int
    {
        return (int)$this->getCollection()->remove($criteria);
    }

    /**
     * @param Container $container
     */
    public function insert(Container $container): Container
    {
        $document = $container->jsonSerialize();
        $this->getCollection()->insert($document);
        return new Container(...$document);
    }

    /**
     * @param array $criteria
     * @param string $_id
     *
     * @return Container
     * @throws \App\Infrastructure\InfrastructureException\InvalidMongoLiteCollectionException
     * @throws \App\Infrastructure\InfrastructureException\InvalidMongoLiteDatabaseException
     */
    public function update(array $criteria, array $data): int
    {
        return $this->getCollection()->update($criteria, $data);
    }

}
