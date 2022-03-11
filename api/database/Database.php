<?php

class Database
{
    private string $host = "localhost";
    private string $db_name = "api_db";
    private string $username = "root";
    private string $password = "";
    public PDO $connection;

// получаем соединение с БД
    public function getConnection(): PDO
    {
        // $this->connection = null;

        try {
            // $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // $this->connection->exec("set names utf8");
            $this->connection = new PDO("sqlite:C:\Users\us-in-of-03\Desktop\Backend\Self\ydtext\api\database\db.sqlite");

        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->connection;
    }
}