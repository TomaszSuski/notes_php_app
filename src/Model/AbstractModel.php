<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\ConfigurationException;
use App\Exception\StorageException;
use PDO;
use PDOException;

class AbstractModel
{
    protected PDO $connection;

    public function __construct(array $config)
    {

        try {
            $this->validateConfig($config);
            $this->createConnection($config);
        } catch (PDOException $e) {
            throw new StorageException('Connection exception');
        }
    }

    private function validateConfig(array $config): void
    {
        if (
            empty($config['host'])
            || empty($config['database'])
            || empty($config['user'])
            || empty($config['password'])
        ) {
            throw new ConfigurationException('Storage configuration exception');
        }
    }

    private function createConnection(array $config): void
    {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";

        $this->connection = new PDO(
            $dsn,
            $config['user'],
            $config['password']
        );
    }
}
