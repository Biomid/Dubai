<?php
require 'vendor/autoload.php';
require_once "db/functions.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

function flattenArray($data) {
    $flattenedArray = array();
    array_walk_recursive($data, function($value) use (&$flattenedArray) {
        $flattenedArray[] = $value;
    });
    foreach ($flattenedArray as &$item) {
        $item = str_replace(',', '', $item);
    }
    return $flattenedArray;
}


$connect = db_connect();
$reader = IOFactory::createReader('Xlsx');
$spreadsheet = $reader->load('Viacheslav Yuvenko.xlsx');
$reader->setReadDataOnly(true);
echo "<pre>";
$sheetsCount = $spreadsheet->getSheetCount();
$dataAmount = [];
for ($j = 0; $j < $sheetsCount - 1; $j++) {
    $spreadsheet->getSheet($j);
    $spreadsheet->setActiveSheetIndex($j);

    $startIndex = 9;
    $total = "";
    foreach ($spreadsheet->getActiveSheet()->getRowIterator() as $row) {
        if ($spreadsheet->getActiveSheet()
            ->getRowDimension($row->getRowIndex())->getVisible()) {
            if ($spreadsheet->getActiveSheet()->getCell('A' . $row->getRowIndex())->getValue() == "TOTAL: ") {
                $total = $row->getRowIndex();
            }

            //echo PHP_EOL;
        }
    }

//Проверка на прошлый индекс
    $lastIndex = $total - 1;
    if ($spreadsheet->getActiveSheet()->getCell("A" . $lastIndex)->getValue() == "") {
        $lastIndex = $total - 2;
    }

    $dataAmount = $spreadsheet->getActiveSheet()->rangeToArray(
        "T{$startIndex}:T{$lastIndex}",     // The worksheet range that we want to retrieve
        null,        // Value that should be returned for empty cells
        true,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
        true,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
        true         // Should the array be indexed by cell row and cell column
    );

//    echo print_r($dataMonth) . "\n";
//    echo "<H1>CHECK</H1>";
//
//
//$formattedArray = array_map('formatDate', $dataMonth);
//print_r($formattedArray);
    $dataAmount = flattenArray($dataAmount);
    print_r($dataAmount);
}





//echo "<pre>";
// print_r($dataMonth);
// echo "<H1>CHECK</H1>";
//function formatDate($item) {
//    $date = date('Y-m-01', strtotime($item['B']));
//    return $date;
//}
//
//$formattedArray = array_map('formatDate', $dataMonth);
//print_r($formattedArray);






//$flattenedArray = array();
//array_walk_recursive($dataMonth, function($value) use (&$flattenedArray) {
//    $flattenedArray[] = $value;
//});
//////$flattenedArray = array_filter($flattenedArray);
////
//echo print_r($flattenedArray);
//
//
//function convert_date_string($date){
//    return date('Y-m-01', strtotime(str_replace(':', ' ', $date)));
//}
//$new_dates = array_map('convert_date_string', $flattenedArray);
//print_r($new_dates);
//foreach ($new_dates as $value){
//    echo gettype($value)." ";
//}
//echo "\n";
//echo gettype($start);
//$start .= "-01";
//$end .= "-30";
//echo "\n"."Start = ".$start." End = ".$end."\n";
//
//$sql = "SELECT * FROM `test` WHERE date = '{$start}' ";
//$data = $connect->prepare($sql);
//$data->execute();
//
//$row = $data->rowCount();
//
//if ($row > 0){
//    $result = $data->fetchAll(PDO::FETCH_ASSOC);
//    print_r($result);
//}
//else echo "NO data";
//for ($i = 0; $i < count($new_dates); $i++){
//    $sql = "INSERT INTO `test`( `owner`, `apart_name`, `date`) VALUES (?,?,?)";
//    $data = $connect->prepare($sql);
//    $data->execute(['XAM'.$i, 'URK'.$i,$new_dates[$i]]);
//}





$arr = [
    ['owner' => "Maxim Zinchenko",
        'age' => 22],
    ['owner' => 'Vicktoriy Strelkova',
        'age' => 23]
];

function shorten_owner_name($item) {
    $name = $item['owner'];
    $shortened_name = substr($name, 0, 3);
    $last_name = substr($name, strpos($name, " ") + 1);
    $new_name = $shortened_name . " " . $last_name;
    $item['owner'] = $new_name;
    return $item;
}

$shortened_array = array_map("shorten_owner_name", $arr);
print_r($arr);
print_r($shortened_array);

$to = 'biomid22@gmail.com';
$subject = 'HTML email';

$message = '
<html>
<head>
  <title>HTML email</title>
</head>
<body>
  <p>This is an HTML email message!</p>
</body>
</html>
';

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: maks_zmp@mail.ru' . "\r\n";

mail($to, $subject, $message, $headers);