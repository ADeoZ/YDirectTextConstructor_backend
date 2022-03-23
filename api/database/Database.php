<?php
namespace YDText;

use PDO;
use PDOException;

class Database
{
    private string $host = "host";
    private string $db_name = "api_db";
    private string $username = "root";
    private string $password = "";
    public PDO $connection;

// получаем соединение с БД
    public function getConnection(): PDO
    {
        try {
            // $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // $this->connection->exec("set names utf8");
            $configs = include('config.php');
            $this->connection = new PDO($configs['sqlite_path']);

        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->connection;
    }
}