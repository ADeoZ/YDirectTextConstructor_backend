<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '../vendor/autoload.php';

use YDText\Ads;
use YDText\Database;
use YDText\Links;

// получаем отправленные данные
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->ads)) {
//    array_filter(get_object_vars($data->ads[0]));

    // получаем соединение с базой данных
    $database = new Database();
    $db = $database->getConnection();
    // подготовка объекта
    $links = new Links($db);
    // генерация новой ссылки
    $linkInfo = $links->create();

    foreach ($data->ads as $item) {
        // проверяем на полноту полей
        $fullFields = array_filter(get_object_vars($item), static function ($field) {
            return $field !== null && trim($field) !== '';
        });
        if (!empty($fullFields)) {
            // создаём новый объект объявления
            $ads = new Ads($db);
            // устанавливаем значения свойств
            $ads->header = $item->header ?? "";
            $ads->extraheader = $item->extraheader ?? "";
            $ads->text = $item->text ?? "";
            $ads->url = $item->url ?? "";
            $ads->showurl = $item->showurl ?? "";
            $ads->callout_0 = $item->callout_0 ?? "";
            $ads->callout_1 = $item->callout_1 ?? "";
            $ads->callout_2 = $item->callout_2 ?? "";
            $ads->callout_3 = $item->callout_3 ?? "";
            $ads->sitelink_0_name = $item->sitelink_0_name ?? "";
            $ads->sitelink_0_link = $item->sitelink_0_link ?? "";
            $ads->sitelink_0_descr = $item->sitelink_0_descr ?? "";
            $ads->sitelink_1_name = $item->sitelink_1_name ?? "";
            $ads->sitelink_1_link = $item->sitelink_1_link ?? "";
            $ads->sitelink_1_descr = $item->sitelink_1_descr ?? "";
            $ads->sitelink_2_name = $item->sitelink_2_name ?? "";
            $ads->sitelink_2_link = $item->sitelink_2_link ?? "";
            $ads->sitelink_2_descr = $item->sitelink_2_descr ?? "";
            $ads->sitelink_3_name = $item->sitelink_3_name ?? "";
            $ads->sitelink_3_link = $item->sitelink_3_link ?? "";
            $ads->sitelink_3_descr = $item->sitelink_3_descr ?? "";
            $ads->sitelink_4_name = $item->sitelink_4_name ?? "";
            $ads->sitelink_4_link = $item->sitelink_4_link ?? "";
            $ads->sitelink_4_descr = $item->sitelink_4_descr ?? "";
            $ads->sitelink_5_name = $item->sitelink_5_name ?? "";
            $ads->sitelink_5_link = $item->sitelink_5_link ?? "";
            $ads->sitelink_5_descr = $item->sitelink_5_descr ?? "";
            $ads->sitelink_6_name = $item->sitelink_6_name ?? "";
            $ads->sitelink_6_link = $item->sitelink_6_link ?? "";
            $ads->sitelink_6_descr = $item->sitelink_6_descr ?? "";
            $ads->sitelink_7_name = $item->sitelink_7_name ?? "";
            $ads->sitelink_7_link = $item->sitelink_7_link ?? "";
            $ads->sitelink_7_descr = $item->sitelink_7_descr ?? "";
            $ads->link_id = $linkInfo["id"];

            if (!$ads->create()) {
                // установим код ответа - 503 сервис недоступен
                http_response_code(503);
                // сообщим пользователю
                echo json_encode(array("error" => "Невозможно создать объявление."), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                die();
            }
        } // если получено пустое объявление
        else {
            // установим код ответа - 400 неверный запрос
            http_response_code(400);
            // сообщим пользователю
            echo json_encode(array("error" => "Невозможно записать объявление. Данные неполные."), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    // установим код ответа - 201 создано
    http_response_code(201);
    // сообщим пользователю
    echo json_encode(array("message" => "Объявления записаны.", "link" => $linkInfo["link"]), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);

} // сообщим пользователю что данные неполные
else {
    // установим код ответа - 400 неверный запрос
    http_response_code(400);
    // сообщим пользователю
    echo json_encode(array("error" => "Невозможно записать объявления. Данные неполные."), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
}