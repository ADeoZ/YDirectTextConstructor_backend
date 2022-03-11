<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключение файла для соединения с базой и файл с объектом
include_once '../database/Database.php';
include_once '../objects/Ads.php';
include_once '../objects/Links.php';

$database = new Database();
$db = $database->getConnection();
$links = new Links($db);
echo $links->create();

//// получаем отправленные данные
//$data = json_decode(file_get_contents("php://input"));
//
//// убеждаемся, что данные не пусты
//if (
//    !empty($data->header) &&
//    !empty($data->text) &&
//    !empty($data->url)
//) {
//    // получаем соединение с базой данных
//    $database = new Database();
//    $db = $database->getConnection();
//    // подготовка объекта
//    $ads = new Ads($db);
//    // устанавливаем значения свойств товара
//    $ads->header = $data->header;
//
//    // если не удается записать объявление, сообщим пользователю
//    if(!$ads->create()){
//        // установим код ответа - 503 сервис недоступен
//        http_response_code(503);
//        // сообщим пользователю
//        echo json_encode(array("message" => "Невозможно создать объявление."), JSON_UNESCAPED_UNICODE);
//    }
//
//    // установим код ответа - 201 создано
//    http_response_code(201);
//    // сообщим пользователю
//    echo json_encode(array("message" => "Объявления записаны."), JSON_UNESCAPED_UNICODE);
//}
//// сообщим пользователю что данные неполные
//else {
//    // установим код ответа - 400 неверный запрос
//    http_response_code(400);
//    // сообщим пользователю
//    echo json_encode(array("message" => "Невозможно записать объявления. Данные неполные."), JSON_UNESCAPED_UNICODE);
//}