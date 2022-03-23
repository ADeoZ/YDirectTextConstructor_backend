<?php

namespace YDText;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Spreadsheets
{
    private Spreadsheet $spreadsheet;

    // конструктор для создания новой таблицы
    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
    }

    // создание первичных заголовков
    public function createTemplate(): void
    {

    }

    // запись объявлений в файл
    public function inputAds(array $ads): bool
    {
        return true;
    }

    // сохрание файла в формате xls
    public function getFile(): Xls
    {

    }
}

//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="result.xlsx"');
//header('Cache-Control: max-age=0');
//
//$spreadsheet = new Spreadsheet();
//$sheet = $spreadsheet->getActiveSheet();
//$sheet->setCellValue('A1', 'Hello World !');
//
//$writer = new Xlsx($spreadsheet);
//// $writer->save('hello world.xlsx');
//$writer->save("php://output");