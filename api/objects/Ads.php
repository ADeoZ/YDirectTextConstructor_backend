<?php

class Ads
{
    // подключение к базе данных и таблице 'products'
    private PDO $connection;

    // свойства объекта
    public int $id;
    public string $header;
    public string $extraheader;
    public string $text;
    public string $url;
    public string $showurl;
    public string $callout_1;
    public string $callout_2;
    public string $callout_3;
    public string $callout_4;
    public string $sitelink_1_name;
    public string $sitelink_1_link;
    public string $sitelink_1_descr;
    public string $sitelink_2_name;
    public string $sitelink_2_link;
    public string $sitelink_2_descr;
    public string $sitelink_3_name;
    public string $sitelink_3_link;
    public string $sitelink_3_descr;
    public string $sitelink_4_name;
    public string $sitelink_4_link;
    public string $sitelink_4_descr;
    public string $sitelink_5_name;
    public string $sitelink_5_link;
    public string $sitelink_5_descr;
    public string $sitelink_6_name;
    public string $sitelink_6_link;
    public string $sitelink_6_descr;
    public string $sitelink_7_name;
    public string $sitelink_7_link;
    public string $sitelink_7_descr;
    public string $sitelink_8_name;
    public string $sitelink_8_link;
    public string $sitelink_8_descr;

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->connection = $db;
    }

    // запрос для чтения объялвений по ссылке
    public function readByLink(string $link): PDOStatement
    {
        $query = "SELECT
            header,
            extraheader,
            text,
            url,
            showurl,
            callout_1,
            callout_2,
            callout_3,
            callout_4,
            sitelink_1_name,
            sitelink_1_link,
            sitelink_1_descr,
            sitelink_2_name,
            sitelink_2_link,
            sitelink_2_descr,
            sitelink_3_name,
            sitelink_3_link,
            sitelink_3_descr,
            sitelink_4_name,
            sitelink_4_link,
            sitelink_4_descr,
            sitelink_5_name,
            sitelink_5_link,
            sitelink_5_descr,
            sitelink_6_name,
            sitelink_6_link,
            sitelink_6_descr,
            sitelink_7_name,
            sitelink_7_link,
            sitelink_7_descr,
            sitelink_8_name,
            sitelink_8_link,
            sitelink_8_descr
        FROM ads a LEFT JOIN links l on l.id = a.link_id WHERE link = :link";

        // подготовка запроса
        $stmt = $this->connection->prepare($query);

        // привязываем ссылку, по которой будем искать
        $stmt->bindParam(':link', $link);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }
}