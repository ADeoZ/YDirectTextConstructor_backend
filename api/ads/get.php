<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require '../vendor/autoload.php';

use YDText\Ads;
use YDText\Database;

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$ads = new Ads($db);

// установим свойство ID записи для чтения
$getLink = isset($_GET['link']) ? $_GET['link'] : die();

// прочитаем детали товара для редактирования
$stmt = $ads->readByLink($getLink);

// массив товаров
$adsArray = array();

// получаем содержимое таблицы
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $adsArray[] = $row;
}

if (count($adsArray) > 0) {
    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные объявлений в формате JSON
    echo json_encode(["ads" => $adsArray], JSON_THROW_ON_ERROR);
} else {
    // код ответа - 404 Не найдено
    http_response_code(404);

    // объект не существует
    echo json_encode(array("error" => "Объявления не существуют."), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
}