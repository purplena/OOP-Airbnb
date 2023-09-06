<?php  

namespace Core\Repository;

use PDO;
use Core\Model\Model;
use Core\Database\Database;
use Core\Database\DatabaseConfigInterface;

abstract class Repository 
{
    protected PDO $pdo;

    abstract public function getTableName(): string;

    public function __construct(DatabaseConfigInterface $config)
    {
        $this->pdo = Database::getPDO($config);
    }

    protected function readAll(string $class_name): array
    {
        $arr_result = [];
        $query = sprintf('SELECT * FROM %s', $this->getTableName());
        $stmt = $this->pdo->query($query);
        if(!$stmt) return $arr_result;

        while ($row_data = $stmt->fetch()) {
            $arr_result[] = new $class_name($row_data);
        }

        return $arr_result; 
    } 

    //why we return Model 
    protected function readById(string $class_name, int $id)
    {
        $query = sprintf('SELECT * FROM %s WHERE id = :id' , $this->getTableName());
        $stmt = $this->pdo->prepare($query);
        if(!$stmt) return null;

        $stmt->execute(['id' => $id]);

        $row_data = $stmt->fetch();

        return !empty($row_data) ? new $class_name($row_data) : null;
    } 

    protected function deleteById(int $id): bool
    {
        $query = sprintf('DELETE FROM %s WHERE id = :id' , $this->getTableName());
        $stmt = $this->pdo->prepare($query);
        if(!$stmt) return null;
        $stmt->execute(['id' => $id]);

        return true;
    }
}