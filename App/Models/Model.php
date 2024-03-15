<?php

namespace App\Models;

use config\Database\DBConnection;
use App\Exceptions\DatabaseException;


abstract class Model
{

    protected $db;
    protected $table;

    public function __construct()
    {
    }

    private function executeQuery(string $query, array $params = []): \PDOStatement
    {
        try {
            $this->db = $this->db ?? (new DBConnection())->connect();
            $stmt = $this->db->prepare($query);

            foreach ($params as $key => $param) {
                $stmt->bindValue($key, $param);
            }

            $stmt->execute();
            return $stmt;
        } catch (\PDOException $e) {
            // Log the error here
            throw DatabaseException::error("Database Error : {$e->getMessage()} ", "query: {$query}");
        }
    }

    protected function executeSQL(string $query, $fetchMode = null, array $params = [])
    {
        $stmt = $this->executeQuery($query, $params);

        switch ($fetchMode) {
            case 'fetchAll':
                $stmt->setFetchMode(\PDO::FETCH_CLASS, get_class($this));
                return $stmt->fetchAll();
            case 'fetch':
                $stmt->setFetchMode(\PDO::FETCH_CLASS, get_class($this));
                return $stmt->fetch();
            case 'fetchColumn':
                return $stmt->fetchColumn();
            default:
                // Handle unsupported fetch mode gracefully
                return $stmt;
        }
    }
}
