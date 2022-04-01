<?php
// необходимые HTTP-заголовки
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="result.xlsx"');
//header('Cache-Control: max-age=0');

require '../vendor/autoload.php';

use YDText\Spreadsheets;

// получаем отправленные данные
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->ads)) {
    $spreadsheet = new Spreadsheets();
    $spreadsheet->createTemplate();

    foreach ($data->ads as $item) {
        // проверяем на полноту полей
        $fullFields = array_filter(get_object_vars($item), static function ($field) {
            return $field !== null && trim($field) !== '';
        });
        if (!empty($fullFields)) {
            if (!$spreadsheet->inputAds(get_object_vars($item))) {
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

    $spreadsheet->getFile();
    // установим код ответа - 201 создано
    http_response_code(201);
    // сообщим пользователю
    echo json_encode(array("message" => "Объявления записаны.", "file" => 'file.xls'), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
} // сообщим пользователю что данные неполные
else {
    // установим код ответа - 400 неверный запрос
    http_response_code(400);
    // сообщим пользователю
    echo json_encode(array("error" => "Невозможно сохранить объявления. Данные неполные."), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
}