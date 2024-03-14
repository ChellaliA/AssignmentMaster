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
   // var_dump($query);
    $this->db = (new DBConnection())->connect();
    $stmt = $this->db->prepare($query);
    foreach ($params as $key => $param) {
      $stmt->bindValue(':' . $key, $param);
    }
    try {
      $stmt->execute();
    } catch (\PDOException $e) {
      throw DatabaseException::error("Database Error : {$e->getMessage()} ", "query: {$query}");
    }
    return $stmt;
  }

 
  public function readOne(array $filters, array $columns = [], array $joins = [], $groupBy = ''): mixed
  {

    $select = empty($columns) ? '*' : implode(',', $columns);
    $query = "SELECT $select FROM {$this->table}";

    // Add any necessary inner join statements
    foreach ($joins as $join) {
      if (!isset($join['join'])) {
        $join['join'] = 'INNER';
      }
      $query .= ' ' . $join['join'] . ' JOIN ' . $join['table'] . ' ON ' . $join['on'];
    }

    if (!empty($filters)) {
      $whereClause = $this->generateWhereClause($filters);
      $query .= " WHERE {$whereClause['query']}";
      $filters = $whereClause['filters'];
    }
    if (!empty($groupBy)) {
      $query .= " GROUP BY $groupBy";
    }

    $stmt = $this->executeQuery($query, $filters);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, get_class($this));
    $result = $stmt->fetch();
    return $result;
  }

  public function readMany(array $filters = [],  array $order = [], int $limit = null,
                          int $offset = null, array $columns = [], array $joins = [], $groupBy = ''): mixed
  {
    $select = empty($columns) ? '*' : implode(',', $columns);
    $query = "SELECT $select FROM {$this->table}";

    // Add any necessary inner join statements
    foreach ($joins as $join) {
      if (!isset($join['join'])) {
        $join['join'] = 'INNER';
      }
      $query .= ' ' . $join['join'] . ' JOIN ' . $join['table'] . ' ON ' . $join['on'];
    }

    if (!empty($filters)) {
      $whereClause = $this->generateWhereClause($filters);
      $query .= " WHERE {$whereClause['query']}";
      $filters = $whereClause['filters'];
    }


    if (!empty($groupBy)) {
      $query .= " GROUP BY $groupBy";
    }

    if (!empty($order)) {
      $query .= ' ORDER BY ';
      foreach ($order as $key => $val) {
        $query .= ' ' . $val;
        if ($key != array_key_last($order)) $query .= ', ';
      }
    }

    if (isset($limit)) {
      $query .= ' LIMIT ' . $limit;
      if (isset($offset)) {
        $query .= ' OFFSET ' . $offset;
      }
    }

    $stmt = $this->executeQuery($query, $filters);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, get_class($this));
    return $stmt->fetchAll();
  }



  public function create(array $fields): \PDOStatement
  {
    $query = "INSERT INTO " . $this->table . " (";
    foreach (array_keys($fields) as $field) {
      $query .= $field;
      if ($field != array_key_last($fields)) $query .= ', ';
    }
    $query .= ') VALUES (';
    foreach (array_keys($fields) as $field) {
      $query .= ':' . $field;
      if ($field != array_key_last($fields)) $query .= ', ';
    }
    $query .= ')';
    return $this->executeQuery($query, $fields);
  }


  public function update(array $fields, array $filters): \PDOStatement
  {

    $query = "UPDATE " . $this->table . " SET ";
    foreach (array_keys($fields) as $field) {
      $query .= $field . " = :" . $field;
      if ($field != array_key_last($fields)) $query .= ', ';
    }
    if (!empty($filters)) {
      $whereClause = $this->generateWhereClause($filters);
      $query .= " WHERE {$whereClause['query']}";
      $filters = $whereClause['filters'];
    }

    $params = array_merge($fields, $filters); // merge $fields and $filters
    return $this->executeQuery($query, $params);
  }

 
  public function delete(array $filters): \PDOStatement
  {
    $query = "DELETE FROM  {$this->table}";
    if (!empty($filters)) {
      $whereClause = $this->generateWhereClause($filters);
      $query .= " WHERE {$whereClause['query']}";
      $filters = $whereClause['filters'];
    }
    return $this->executeQuery($query, $filters);
  }

  
  public function count(array $filters = [], array $joins = []): int
  {
    $query = "SELECT COUNT(*) FROM {$this->table}";
    $filtersCount = 0;

    foreach ($joins as $join) {
      $query .= ' INNER JOIN ' . $join['table'] . ' ON ' . $join['on'];
    }
    if (!empty($filters)) {
      $whereClause = $this->generateWhereClause($filters);
      $query .= " WHERE {$whereClause['query']}";
      $filters = $whereClause['filters'];
    }
    $stmt = $this->executeQuery($query, $filters);
    return $stmt->fetchColumn();
  }


  private function generateWhereClause(array $filters): array
  {
    $query = '';
    $newFilters = [];


    foreach ($filters as $filter) {

      if ($this->isArrayOfArrays($filters)) {
        $columnName = str_replace('.', '_', $filter['column']);
        $column = str_replace('.', '.', $filter['column']);

        if (strpos($filter['column'], '.') === false) {
          $column = "{$this->table}.{$column}";
        }

        $operator = $filter['operator'];
        $value = $filter['value'];

        $query .= "{$column} {$operator} :{$columnName} ";
      } else {
        foreach ($filters as $key => $value) {
          $columnName = str_replace('.', '_', $key);
          $column = str_replace('.', '.', $key);

          if (strpos($key, '.') === false) {
            $column = "{$this->table}.{$column}";
          }

          $query .= "{$column} = :{$columnName} ";

          if ($key !== array_key_last($filters)) {
            $query .= 'AND ';
          }

          $newFilters[$columnName] = $value;
        }
      }


      if ($filter !== end($filters)) {
        $query .= 'AND ';
      }

      $newFilters[$columnName] = $value;
    }

    return [
      'query' => $query,
      'filters' => $newFilters
    ];
  }


  private function isArrayOfArrays($variable)
  {
    if (!is_array($variable)) {
      return false;
    }
    $filtered = array_filter($variable, 'is_array');
    return count($filtered) === count($variable);
  }
}
