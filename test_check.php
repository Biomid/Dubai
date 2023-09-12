<?php

require 'vendor/autoload.php';
require_once "db/functions.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

//Соединение с бв
$connect = db_connect();

$reader = IOFactory::createReader('Xlsx');
$spreadsheet = $reader->load('Viacheslav Yuvenko.xlsx');

// Только чтение данных
$reader->setReadDataOnly(true);

//Получение имени владельца и название объекта
$owner = $spreadsheet->getActiveSheet()->getCell("C4")->getValue();
$apartName = $spreadsheet->getActiveSheet()->getCell("C5")->getValue();


//Ищем Total
//Find function strripos
$startIndex = 9;
$total = "";
foreach ($spreadsheet->getActiveSheet()->getRowIterator() as $row) {
    if ($spreadsheet->getActiveSheet()
        ->getRowDimension($row->getRowIndex())->getVisible()) {
        if ($spreadsheet->getActiveSheet()->getCell('A' . $row->getRowIndex())->getValue() == "TOTAL: ") {
            $total = $row->getRowIndex();
        }

        echo PHP_EOL;
    }
}

//Проверка на прошлый индекс
$lastIndex = $total - 1;
if ($spreadsheet->getActiveSheet()->getCell("A" . $lastIndex)->getValue() == "") {
    $lastIndex = $total - 2;
}

//Запись данных
$dataMonth = $spreadsheet->getActiveSheet()->rangeToArray(
    "B{$startIndex}:B{$lastIndex}",     // The worksheet range that we want to retrieve
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataNightOfRent = $spreadsheet->getActiveSheet()->rangeToArray(
    "C{$startIndex}:C{$lastIndex}",     // The worksheet range that we want to retrieve
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataPriceForNight = $spreadsheet->getActiveSheet()->rangeToArray(
    "D{$startIndex}:D{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataOccupancy = $spreadsheet->getActiveSheet()->rangeToArray(
    "E{$startIndex}:E{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataRentalAmount = $spreadsheet->getActiveSheet()->rangeToArray(
    "F{$startIndex}:F{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataDEWA = $spreadsheet->getActiveSheet()->rangeToArray(
    "G{$startIndex}:G{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataDU = $spreadsheet->getActiveSheet()->rangeToArray(
    "H{$startIndex}:H{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataEmpower = $spreadsheet->getActiveSheet()->rangeToArray(
    "I{$startIndex}:I{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataOperation = $spreadsheet->getActiveSheet()->rangeToArray(
    "J{$startIndex}:J{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataCleaning = $spreadsheet->getActiveSheet()->rangeToArray(
    "K{$startIndex}:K{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataGAZ = $spreadsheet->getActiveSheet()->rangeToArray(
    "L{$startIndex}:L{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataDTCM = $spreadsheet->getActiveSheet()->rangeToArray(
    "M{$startIndex}:M{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataOwnersOutstanding = $spreadsheet->getActiveSheet()->rangeToArray(
    "N{$startIndex}:N{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataAutlOfFix = $spreadsheet->getActiveSheet()->rangeToArray(
    "O{$startIndex}:O{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataPercent = $spreadsheet->getActiveSheet()->rangeToArray(
    "P{$startIndex}:P{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataAmount = $spreadsheet->getActiveSheet()->rangeToArray(
    "Q{$startIndex}:Q{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataVAT = $spreadsheet->getActiveSheet()->rangeToArray(
    "R{$startIndex}:R{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataTotalCommission = $spreadsheet->getActiveSheet()->rangeToArray(
    "S{$startIndex}:S{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataAmountToBePaid = $spreadsheet->getActiveSheet()->rangeToArray(
    "T{$startIndex}:T{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataAmountTransferred = $spreadsheet->getActiveSheet()->rangeToArray(
    "U{$startIndex}:V{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

$dataDate = $spreadsheet->getActiveSheet()->rangeToArray(
    "V{$startIndex}:V{$lastIndex}",     // The worksheet range that we want to retrieve===
    null,        // Value that should be returned for empty cells
    true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
    true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
    true         // Should the array be indexed by cell row and cell column
);

//Запись данных в базу данных
$index_difference = $lastIndex - $startIndex;
for ($i = $startIndex; $i <= $lastIndex; $i++) {
    $insert_query = "INSERT INTO `file_data` (`owner`, `apart_name`, `month`, `nights_of_rent`, `price_for_night`,
                         `occupancy`, `rental_amount`, `DEWA`,`DU_etisalat`,`empower_cooling_deyaar`, `operation_expenses_maintenance`,
                          `GAZ`, `DTCM`, `cleaning_concierge_service`, `owner_outstanding_to_company`,
                         `autl_or_fix`, `percent`, `amount`, `VAT_5`, `total_commission`, `amount_to_be_paid`, `amount_transferred`, `date`)
                         VALUE ('{$owner}', '{$apartName}', ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $data = $connect->prepare($insert_query);
    $data->execute([
        implode($dataMonth[$i]),
        implode($dataNightOfRent[$i]),
        implode($dataPriceForNight[$i]),
        implode($dataOccupancy[$i]),
        implode($dataRentalAmount[$i]),
        implode($dataDEWA[$i]),
        implode($dataDU[$i]),
        implode($dataEmpower[$i]),
        implode($dataOperation[$i]),
        implode($dataGAZ[$i]),
        implode($dataDTCM[$i]),
        implode($dataCleaning[$i]),
        implode($dataOwnersOutstanding[$i]),
        implode($dataAutlOfFix[$i]),
        implode($dataPercent[$i]),
        implode($dataAmount[$i]),
        implode($dataVAT[$i]),
        implode($dataTotalCommission[$i]),
        implode($dataAmountToBePaid[$i]),
        implode($dataAmountTransferred[$i]),
        implode($dataDate[$i])
    ]);
}

//echo "<pre>";
//echo print_r($dataPriceForNight);
//echo "</pre>";
