<?php
require 'AbstractModel.php';

class UserModel extends AbstractModel
{
    protected string $table;

    public function __construct()
    {
        // Appel du contrcut du parent pour init db
        parent::__construct();
        // Init de la table en cours
        $this->table = 'user';
    }

    public function findByEmail(string $mail): ?array
    {
        $q = $this->db->prepare('SELECT id, name, email, password FROM user WHERE email = :mail');
        $q->execute([':mail' => $mail]);

        return $q->fetch();
    }

    public function findByName(string $name): ?array
    {
        $q = $this->db->prepare('SELECT id, name FROM user WHERE name LIKE :word');
        $q->execute([':mail' => "%$name%"]);

        return $q->fetchAll();
    }

    public function insert(string $name, string $email, string $password): ?int
    {
        $q = $this->db->prepare(
            'INSERT INTO user(name, email, password, created_at)
            VALUES (:name ,:email ,:password , NOW())'
        );

        return $q->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }
}
