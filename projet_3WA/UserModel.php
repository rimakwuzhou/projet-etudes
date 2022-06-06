<?php

class UserModel
{
    // Définition des propriétés
    private PDO $db;
    private string $table;
    const DB_USER = 'root'; // const DB_USER = 'root'
    const DB_PASS = 'root'; // Attention sur windows le mdp est vide
    const DB_HOST = 'localhost';
    // Config de base host : localhost / 127.0.0.1
    const DB_NAME = 'demo_user'; // Pensez à choisir la bonne bdd

    public function __construct()
    {
        $this->db =
            new PDO(
                'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME . ';charset=UTF8',
                self::DB_USER,
                self::DB_PASS,
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        $this->table = 'user';
    }

    public function create(string $name, string $email, string $password)
    {
        $insert = $this->db->prepare(
            'INSERT INTO user(name, email, pwd, created_at)
            VALUES (:nom, :mail, :pwd, NOW())'
        );

        // Commit ma requête
        // usage du password_hash pour proteger le password (bcrypt)
        $insert->execute([
            ':nom'     => $name,
            ':mail'    => $email,
            ':pwd'     => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    public function findByEmail(string $mail)
    {
        $q = $this->db->prepare(
            'SELECT id, name, email, pwd
            FROM user
            WHERE email = :mail'
        );
        $q->execute([':mail' => $mail]);
        return $q->fetch();
    }

    public function findAll()
    {
        $q = $this->db->query(
            'SELECT id, name, email
            FROM user'
        );
        return $q->fetchAll();
    }
}
