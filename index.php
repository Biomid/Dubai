<?php
mb_internal_encoding("UTF-8");
//csv to array
$row =[];
if (($handle = fopen("Test1.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0)) !== FALSE) {
       $row[] = $data;
    }
    echo "<hr>";
    fclose($handle);
}
echo "<pre>";
var_dump($row);
echo "</pre>";

//open and read csv file
echo "<pre>";
if (($handle = fopen("Test1.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0)) !== FALSE) {
        $out = '';
        for ($i = 0; $i < count($data); $i++){
            $out .= $data[$i]." ";
        }
        echo $out;
        echo "<hr>";
    }
    fclose($handle);
}