<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Container;

use App\Infrastructure\InfrastructureException\InvalidMongoLiteCollectionException;
use App\Infrastructure\InfrastructureException\InvalidMongoLiteDatabaseException;
use MongoLite\Client;

abstract class MongoLiteAware
{
    protected Client $mongoClient;
    protected string $database;

    abstract protected function getCollectionName();

    /**
     * @param Client $mongoClient
     */
    public function __construct(Client $mongoClient, string $database)
    {
        $this->mongoClient = $mongoClient;
        $this->database    = $database;
    }

    /**
     * @return \MongoLite\Database
     * @throws InvalidMongoLiteDatabaseException
     */
    protected function getDatabase()
    {

        if (empty($this->database)) {
            throw new InvalidMongoLiteDatabaseException();
        }

        return $this->mongoClient->selectDB($this->database);
    }

    /**
     * @return \MongoLite\Collection
     * @throws InvalidMongoLiteCollectionException
     * @throws InvalidMongoLiteDatabaseException
     */
    protected function getCollection()
    {

        if (empty($this->getCollectionName())) {
            throw new InvalidMongoLiteCollectionException();
        }

        return $this->getDatabase()->selectCollection($this->getCollectionName());
    }


}