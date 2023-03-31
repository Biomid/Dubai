<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

echo phpinfo();
$reader = IOFactory::createReader('Xlsx');
$spreadsheet = $reader->load('clop.xlsx');
// Только чтение данных
$reader->setReadDataOnly(true);

// Количество листов
$sheetsCount = $spreadsheet->getSheetCount();
$sheetName = $spreadsheet->getSheetNames();
// Данные в виде массива
$temp = array();
for ($i = 0; $i < $sheetsCount;$i++){
    $data = $spreadsheet->getSheet($i)->toArray();
    array_push($temp,$data);
}
$cellValue = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, 5)->getValue();
$dataArray = $spreadsheet->getActiveSheet()
    ->rangeToArray(
        'B3:E6',     // The worksheet range that we want to retrieve
        "Hello",        // Value that should be returned for empty cells
        TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
        TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
        TRUE         // Should the array be indexed by cell row and cell column
    );
$rowValue = $spreadsheet->getActiveSheet()->getCell('C5')->getValue();
echo $rowValue." ";
echo $cellValue." ".implode(",",$sheetName);



echo "<pre>";
var_dump($dataArray);
echo "</pre>";

$cellNum = $spreadsheet->getActiveSheet()->getCoordinates();
echo "<pre>";
var_dump($cellNum);
echo "</pre>";

foreach ($spreadsheet->getActiveSheet()->getRowIterator() as $row) {
    if ($spreadsheet->getActiveSheet()
        ->getRowDimension($row->getRowIndex())->getVisible()) {
        echo '    Row number - ' , $row->getRowIndex() , ' ';
        echo $spreadsheet->getActiveSheet()
            ->getCell(
                'D'.$row->getRowIndex()
            )
            ->getValue(), ' '."<br>";
        if ($spreadsheet->getActiveSheet()->getCell('D'.$row->getRowIndex())->getValue() == "моча"){
            $temp = "D".$row->getRowIndex();
            echo $temp;
        }

        echo PHP_EOL;
    }
}