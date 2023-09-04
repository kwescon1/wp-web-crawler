<?php

namespace App\Services\Database;

use Predis\Response\Status;

interface RedisServiceInterface
{

    public function setKeyValue(string $key, int $seconds, bool $value): Status;

    public function getKeyValue(string $key): ?string;
}
