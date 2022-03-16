<?php

class Links
{
    // подключение к базе данных и таблице 'products'
    private PDO $connection;

    // свойства объекта
    public string $link;

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->connection = $db;
    }

    // генерируем случайную строку
    private function random_str(): string
    {
        $length = 32;
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces [] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    public function findOne(): int
    {
        // запрос для чтения одной записи
        $query = "SELECT id FROM links WHERE link = :link LIMIT 0,1";

        // подготовка запроса
        $stmt = $this->connection->prepare($query);

        // привязываем ссылку, по которой будем искать
        $stmt->bindParam(':link', $this->link);

        // выполняем запрос
        $stmt->execute();

        // получаем извлеченную строку
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // возвращаем id найденной записи
        return $row['id'] ?? 0;
    }

    // создаём ссылку
    public function create(): ?array
    {
        $id = 1;
        $generatedLink = '';
        while ($id) {
            $generatedLink = $this->random_str();
            $this->link = $generatedLink;
            $id = $this->findOne();
        }

        // запрос для создания записи
        $query = "INSERT INTO links (link) VALUES (:link)";

        // подготовка запроса
        $stmt = $this->connection->prepare($query);

        // привязка значений
        $stmt->bindParam(":link", $generatedLink);

        // выполняем запрос
        if ($stmt->execute()) {
            return array("id" => $this->connection->lastInsertId(), "link" => $generatedLink);
        }
        return null;
    }
}