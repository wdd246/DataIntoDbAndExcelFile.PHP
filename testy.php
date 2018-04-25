<meta charset="utf-8">
<?php  
header('Content-Type: text/html; charset=utf-8');
require_once("conn.php");  //connection file
$conn = new mysqli($host, $user, $pass);   //connecting with DB
mysqli_select_db($conn, $db);  

mysqli_query($conn,"SET NAMES 'utf8'");  //Language
mysqli_query($conn,"SET NAMES `utf8` COLLATE `utf8_polish_ci`"); 

$setSql = "SELECT * FROM $table";   //Downloading data from DB
$setRec = mysqli_query($conn, $setSql);  
  
//Drawing columns in excel by columns in DB
$columnHeader = '';  
$columnHeader = "ID" . "\t" . "Imię" . "\t" . "Nazwisko" . "\t" . "E-mail" . "\t" . "Telefon" . "\t" . "Ulica" . "\t" . "Nr. domu" . "\t" . "Nr. lokalu" . "\t" ."Kod pocztowy" . "\t" . "Miejscowość" . "\t" . "Imie dziecka" . "\t" . "Rok_urodzenia" ."\t";  //format kolumn do excela
  
$setData = '';  
  
while ($rec = mysqli_fetch_row($setRec)) {  //Inserting into EXCEL
    $rowData = '';  
    foreach ($rec as $value) {  
        mysqli_query($conn,"SET NAMES 'utf8'");  //Language
        mysqli_query($conn,"SET NAMES `utf8` COLLATE `utf8_polish_ci`"); 
        header("Content-type: application/octet-stream; charset=UTF-8");
        utf8_encode($value = '"' . $value . '"' . "\t");  
        utf8_encode($rowData .= $value);  
        
    }  
    mysqli_query($conn,"SET NAMES 'utf8'");  //Language
    mysqli_query($conn,"SET NAMES `utf8` COLLATE `utf8_polish_ci`"); 
    header("Content-type: application/octet-stream; charset=UTF-8");
    utf8_encode($setData .= trim($rowData) . "\n");  
}  

$filename = "Próbkiata_" . date('Ymd') . ".xls";  //Excel file name
  
//Language in excel
header("Content-type: application/octet-stream; charset=UTF-8");
header("Content-type: application/octet-stream; charset=UTF-8");
header("Content-type: application/vnd.ms-excel; charset=UTF-8" );
header("Content-Transfer-Encoding: binary; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"$filename\"; charset=UTF-8");  
header("Pragma: no-cache; charset=UTF-8");  
header("Expires: 0; charset=UTF-8");  
header('Content-Type: text/html; charset=utf-8');
  
echo ucwords($columnHeader) . "\n" . $setData . "\n";  
  
?>  