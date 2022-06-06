<?php

declare(strict_types=1);

abstract class AbstractModel
{
    const DB_TYPE = 'mysql';
    const DB_HOST = 'localhost';
    const DB_PORT = '3306';
    const DB_NAME = 'user_m';
    const DB_USER = 'root';
    const DB_PASS = 'root';

    protected PDO $db;
    protected string $table;

    protected function __construct()
    {
        $this->db = new PDO(
            self::DB_TYPE . ':host=' . self::DB_HOST . ';dbname=' . self::DB_NAME . ';charset=UTF8',
            self::DB_USER,
            self::DB_PASS,
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    public function findById(int $id): ?array
    {
        $q = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $q->execute([':id' => $id]);
        return $q->fetch();
    }

    public function findAll(): ?array
    {
        $q = $this->db->query("SELECT * FROM {$this->table}");
        return $q->fetchAll();
    }
}
