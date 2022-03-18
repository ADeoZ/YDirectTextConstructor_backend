<?php

class Ads
{
    // подключение к базе данных и таблице 'products'
    private PDO $connection;

    // свойства объекта
    public int $link_id;
    public string $header;
    public string $extraheader;
    public string $text;
    public string $url;
    public string $showurl;
    public string $callout_0;
    public string $callout_1;
    public string $callout_2;
    public string $callout_3;
    public string $sitelink_0_name;
    public string $sitelink_0_link;
    public string $sitelink_0_descr;
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
            callout_0,
            callout_1,
            callout_2,
            callout_3,
            sitelink_0_name,
            sitelink_0_link,
            sitelink_0_descr,
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
            sitelink_7_descr
        FROM ads a LEFT JOIN links l on l.id = a.link_id WHERE link = :link";

        // подготовка запроса
        $stmt = $this->connection->prepare($query);

        // привязываем ссылку, по которой будем искать
        $stmt->bindParam(':link', $link);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }

    // метод для записи нового объявления
    public function create(): bool
    {
        // запрос для вставки (создания) записей
        $query = "INSERT INTO ads (
                 header,
                 extraheader,
                 text,
                 url,
                 showurl,
                 callout_0,
                 callout_1,
                 callout_2,
                 callout_3,
                 sitelink_0_name,
                 sitelink_0_link,
                 sitelink_0_descr,
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
                 link_id                 
                 ) VALUES (
                 :header,
                 :extraheader,
                 :text,
                 :url,
                 :showurl,
                 :callout_0,
                 :callout_1,
                 :callout_2,
                 :callout_3,
                 :sitelink_0_name,
                 :sitelink_0_link,
                 :sitelink_0_descr,
                 :sitelink_1_name,
                 :sitelink_1_link,
                 :sitelink_1_descr,
                 :sitelink_2_name,
                 :sitelink_2_link,
                 :sitelink_2_descr,
                 :sitelink_3_name,
                 :sitelink_3_link,
                 :sitelink_3_descr,
                 :sitelink_4_name,
                 :sitelink_4_link,
                 :sitelink_4_descr,
                 :sitelink_5_name,
                 :sitelink_5_link,
                 :sitelink_5_descr,
                 :sitelink_6_name,
                 :sitelink_6_link,
                 :sitelink_6_descr,
                 :sitelink_7_name,
                 :sitelink_7_link,
                 :sitelink_7_descr,
                 :link_id
                 )";

        // подготовка запроса
        $stmt = $this->connection->prepare($query);

        // очистка
        $this->header = htmlspecialchars(strip_tags($this->header));
        $this->extraheader = htmlspecialchars(strip_tags($this->extraheader));
        $this->text = htmlspecialchars(strip_tags($this->text));
        $this->url = htmlspecialchars(strip_tags($this->url));
        $this->showurl = htmlspecialchars(strip_tags($this->showurl));
        $this->callout_0 = htmlspecialchars(strip_tags($this->callout_0));
        $this->callout_1 = htmlspecialchars(strip_tags($this->callout_1));
        $this->callout_2 = htmlspecialchars(strip_tags($this->callout_2));
        $this->callout_3 = htmlspecialchars(strip_tags($this->callout_3));
        $this->sitelink_0_name = htmlspecialchars(strip_tags($this->sitelink_0_name));
        $this->sitelink_0_link = htmlspecialchars(strip_tags($this->sitelink_0_link));
        $this->sitelink_0_descr = htmlspecialchars(strip_tags($this->sitelink_0_descr));
        $this->sitelink_1_name = htmlspecialchars(strip_tags($this->sitelink_1_name));
        $this->sitelink_1_link = htmlspecialchars(strip_tags($this->sitelink_1_link));
        $this->sitelink_1_descr = htmlspecialchars(strip_tags($this->sitelink_1_descr));
        $this->sitelink_2_name = htmlspecialchars(strip_tags($this->sitelink_2_name));
        $this->sitelink_2_link = htmlspecialchars(strip_tags($this->sitelink_2_link));
        $this->sitelink_2_descr = htmlspecialchars(strip_tags($this->sitelink_2_descr));
        $this->sitelink_3_name = htmlspecialchars(strip_tags($this->sitelink_3_name));
        $this->sitelink_3_link = htmlspecialchars(strip_tags($this->sitelink_3_link));
        $this->sitelink_3_descr = htmlspecialchars(strip_tags($this->sitelink_3_descr));
        $this->sitelink_4_name = htmlspecialchars(strip_tags($this->sitelink_4_name));
        $this->sitelink_4_link = htmlspecialchars(strip_tags($this->sitelink_4_link));
        $this->sitelink_4_descr = htmlspecialchars(strip_tags($this->sitelink_4_descr));
        $this->sitelink_5_name = htmlspecialchars(strip_tags($this->sitelink_5_name));
        $this->sitelink_5_link = htmlspecialchars(strip_tags($this->sitelink_5_link));
        $this->sitelink_5_descr = htmlspecialchars(strip_tags($this->sitelink_5_descr));
        $this->sitelink_6_name = htmlspecialchars(strip_tags($this->sitelink_6_name));
        $this->sitelink_6_link = htmlspecialchars(strip_tags($this->sitelink_6_link));
        $this->sitelink_6_descr = htmlspecialchars(strip_tags($this->sitelink_6_descr));
        $this->sitelink_7_name = htmlspecialchars(strip_tags($this->sitelink_7_name));
        $this->sitelink_7_link = htmlspecialchars(strip_tags($this->sitelink_7_link));
        $this->sitelink_7_descr = htmlspecialchars(strip_tags($this->sitelink_7_descr));

        // привязка значений
        $stmt->bindParam(":header", $this->header);
        $stmt->bindParam(":extraheader", $this->extraheader);
        $stmt->bindParam(":text", $this->text);
        $stmt->bindParam(":url", $this->url);
        $stmt->bindParam(":showurl", $this->showurl);
        $stmt->bindParam(":callout_0", $this->callout_0);
        $stmt->bindParam(":callout_1", $this->callout_1);
        $stmt->bindParam(":callout_2", $this->callout_2);
        $stmt->bindParam(":callout_3", $this->callout_3);
        $stmt->bindParam(":sitelink_0_name", $this->sitelink_0_name);
        $stmt->bindParam(":sitelink_0_link", $this->sitelink_0_link);
        $stmt->bindParam(":sitelink_0_descr", $this->sitelink_0_descr);
        $stmt->bindParam(":sitelink_1_name", $this->sitelink_1_name);
        $stmt->bindParam(":sitelink_1_link", $this->sitelink_1_link);
        $stmt->bindParam(":sitelink_1_descr", $this->sitelink_1_descr);
        $stmt->bindParam(":sitelink_2_name", $this->sitelink_2_name);
        $stmt->bindParam(":sitelink_2_link", $this->sitelink_2_link);
        $stmt->bindParam(":sitelink_2_descr", $this->sitelink_2_descr);
        $stmt->bindParam(":sitelink_3_name", $this->sitelink_3_name);
        $stmt->bindParam(":sitelink_3_link", $this->sitelink_3_link);
        $stmt->bindParam(":sitelink_3_descr", $this->sitelink_3_descr);
        $stmt->bindParam(":sitelink_4_name", $this->sitelink_4_name);
        $stmt->bindParam(":sitelink_4_link", $this->sitelink_4_link);
        $stmt->bindParam(":sitelink_4_descr", $this->sitelink_4_descr);
        $stmt->bindParam(":sitelink_5_name", $this->sitelink_5_name);
        $stmt->bindParam(":sitelink_5_link", $this->sitelink_5_link);
        $stmt->bindParam(":sitelink_5_descr", $this->sitelink_5_descr);
        $stmt->bindParam(":sitelink_6_name", $this->sitelink_6_name);
        $stmt->bindParam(":sitelink_6_link", $this->sitelink_6_link);
        $stmt->bindParam(":sitelink_6_descr", $this->sitelink_6_descr);
        $stmt->bindParam(":sitelink_7_name", $this->sitelink_7_name);
        $stmt->bindParam(":sitelink_7_link", $this->sitelink_7_link);
        $stmt->bindParam(":sitelink_7_descr", $this->sitelink_7_descr);
        $stmt->bindParam(":link_id", $this->link_id);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}