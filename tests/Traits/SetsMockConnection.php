<?php

namespace Tests\Traits;

use PDO;

trait SetsMockConnection
{
    /**
     * Set a mocked PDO connection on a service instance.
     *
     * @param object $service The service instance.
     * @param PDO $pdo The mocked PDO connection.
     */
    protected function setMockConnectionOnService(object $service, PDO $pdo): void
    {
        if (method_exists($service, 'setConnection')) {
            $service->setConnection($pdo);
        }
    }
}
