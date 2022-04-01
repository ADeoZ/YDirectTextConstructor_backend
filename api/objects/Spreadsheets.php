<?php

namespace YDText;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Spreadsheets
{
    private Spreadsheet $spreadsheet;
    private Worksheet $worksheet;
    private int $currentRow;
    private array $headers = ['Заголовок 1', 'Заголовок 2', 'Текст', 'Ссылка', 'Отображаемая ссылка', 'Заголовки быстрых ссылок', 'Описания быстрых ссылок', 'Адреса быстрых ссылок', 'Уточнения'];

    // конструктор для создания новой таблицы
    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        $this->worksheet = $this->spreadsheet->getActiveSheet();
        $this->currentRow = 1;
    }

    // создание первичных заголовков
    public function createTemplate(): void
    {
        // заполняем заголовки таблицы
        $this->worksheet->fromArray([$this->headers], null, 'A' . $this->currentRow);

        // определяем стили для заголовков
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        for ($i = 1, $length = count($this->headers); $i <= $length; $i++) {
            $this->worksheet->getStyleByColumnAndRow($i, $this->currentRow)->applyFromArray($styleArray);
            $this->worksheet->getColumnDimensionByColumn($i)->setAutoSize(true);
            $this->worksheet->mergeCellsByColumnAndRow($i, $this->currentRow, $i, $this->currentRow + 1);
        }
        $this->currentRow += 2;
    }

    // запись объявлений в файл
    public function inputAds(array $ads): bool
    {
        $result = [
            $ads['header'],
            $ads['extraheader'],
            $ads['text'],
            $ads['url'],
            $ads['showurl'],
            $this->joinFields(
                $ads['sitelink_0_name'],
                $ads['sitelink_1_name'],
                $ads['sitelink_2_name'],
                $ads['sitelink_3_name'],
                $ads['sitelink_4_name'],
                $ads['sitelink_5_name'],
                $ads['sitelink_6_name'],
                $ads['sitelink_7_name']
            ),
            $this->joinFields(
                $ads['sitelink_0_descr'],
                $ads['sitelink_1_descr'],
                $ads['sitelink_2_descr'],
                $ads['sitelink_3_descr'],
                $ads['sitelink_4_descr'],
                $ads['sitelink_5_descr'],
                $ads['sitelink_6_descr'],
                $ads['sitelink_7_descr']
            ),
            $this->joinFields(
                $ads['sitelink_0_link'],
                $ads['sitelink_1_link'],
                $ads['sitelink_2_link'],
                $ads['sitelink_3_link'],
                $ads['sitelink_4_link'],
                $ads['sitelink_5_link'],
                $ads['sitelink_6_link'],
                $ads['sitelink_7_link']
            ),
            $this->joinFields(
                $ads['callout_0'],
                $ads['callout_1'],
                $ads['callout_2'],
                $ads['callout_3']
            ),
        ];
        $this->worksheet->fromArray([$result], null, 'A' . $this->currentRow);
        ++$this->currentRow;
        return true;
    }

    // сохрание файла в формате xlsx
    public function getFile(): void
    {
        $this->insertCalcFields();
        $writer = new Xlsx($this->spreadsheet);
        // $writer->save("php://output");
        $writer->save('temp.xlsx');
    }

    // добавляем столбцы с формулами подсчёта длин полей
    private function insertCalcFields(): void
    {
        // определяем столбец и строку для вставки
        $column = array_search('Ссылка', $this->headers, true) + 1;
        $row = 1;
        while ($this->worksheet->getCellByColumnAndRow($column, $row)->getValue() !== 'Ссылка' && $row <= $this->currentRow) {
            echo $row;
            $row++;
        }
        // вставляем заголовки
        $this->worksheet->insertNewColumnBeforeByIndex($column, 3);
        $this->worksheet->setCellValueByColumnAndRow($column, $row, 'Длина');
        $this->worksheet->mergeCellsByColumnAndRow($column, $row, $column + 2, $row);
        // задаём стили заголовкам
        $styleArray = [
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $subHeaders = ['заголовок 1', 'заголовок 2', 'текст'];
        foreach ($subHeaders as $i => $subHeader) {
            $this->worksheet->setCellValueByColumnAndRow($column + $i, $row + 1, $subHeader);
            $this->worksheet->getStyleByColumnAndRow($column + $i, $row + 1)->applyFromArray($styleArray);
        }
        // заполняем поля формулами
        for ($i = $row + 2; $i <= $this->currentRow; $i++) {
            $this->worksheet->setCellValueByColumnAndRow($column, $i, '=IF(A1<>A2,1,2)');
            $this->worksheet->setCellValueByColumnAndRow($column, $i, '=IF(' . Coordinate::stringFromColumnIndex($column - 3) . $i . '="","",LEN(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(' . Coordinate::stringFromColumnIndex($column - 3) . $i . ',"!",""),",",""),".",""),";",""),":",""),"""","")))');
            $this->worksheet->setCellValueByColumnAndRow($column + 1, $i, '=IF(' . Coordinate::stringFromColumnIndex($column - 2) . $i . '="","",LEN(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(' . Coordinate::stringFromColumnIndex($column - 2) . $i . ',"!",""),",",""),".",""),";",""),":",""),"""","")))');
            $this->worksheet->setCellValueByColumnAndRow($column + 2, $i, '=IF(' . Coordinate::stringFromColumnIndex($column - 1) . $i . '="","",LEN(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(' . Coordinate::stringFromColumnIndex($column - 1) . $i . ',"!",""),",",""),".",""),";",""),":",""),"""","")))');
        }
    }

    // соединение полей в строку с разделителем ||
    private function joinFields(?string ...$fields): string
    {
        return implode("||", $fields);
    }
}