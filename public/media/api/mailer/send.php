<?php

$file = $_FILES["r_exl"]["tmp_name"]; 

require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$reader = new Xlsx();
$spreadsheet = $reader->load($file);

$worksheet = $spreadsheet->getActiveSheet();
$highestRow = $worksheet->getHighestRow();

for ($i = 2; $i <= $highestRow; $i++) {
$data[] = $worksheet->getCell('A' . $i)->getValue();
$to = $data;
$to_str = implode(',', $to);
$subject = $_POST["r_sub"];
$body = $_POST["r_msg"];
$mailto = 'mailto:' . $to_str . '?subject=' . $subject . '&body=' . $body;

header("location: ".$mailto);

}



?>