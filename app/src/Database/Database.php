<?php

declare(strict_types=1);

namespace App\Database;

class Database
{
    public function __construct(private Connection $connection)
    {
    }

    public function fetchRecords(string $tableName, array $criteria): array
    {
        $where = [];

        foreach ($criteria as $column => $value) {
            $where[] = "{$column} = :{$column}";
        }

        $sql = "SELECT * FROM {$tableName} WHERE " . implode(' AND ', $where);

        try {
            $statement = $this->connection->getPdo()->prepare($sql);
            foreach ($criteria as $column => $value) {
                $statement->bindValue(":{$column}", $value);
            }

            $statement->execute();
            $result = $statement->fetchAll();
        } catch (\PDOException $exception) {
            $result = [];
        }

        return $result;
    }
}