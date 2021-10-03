<?php
declare(strict_types=1);

namespace App\Domain\Container;

use App\Domain\DomainException\DomainRecordNotFoundException;

class ContainerNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The container you requested does not exist.';
}
