<?php
mb_internal_encoding("UTF-8");
require 'vendor/autoload.php';
require_once "db/functions.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

$reader = IOFactory::createReader('Xlsx');
$spreadsheet = $reader->load('filies/clop.xlsx');
$reader->setReadDataOnly(true);

$dataArray = $spreadsheet->getActiveSheet()
    ->rangeToArray(
        'B1:B5',     // The worksheet range that we want to retrieve
        "",        // Value that should be returned for empty cells
        TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
        TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
        TRUE         // Should the array be indexed by cell row and cell column
    );
echo "<pre>";
var_dump($dataArray);