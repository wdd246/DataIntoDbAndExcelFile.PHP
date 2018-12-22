<?php
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ERROR | E_PARSE);
    
if(isset($_POST["sub"])){ // if submit button clicked
       
    /*
    CONNECTION TO DB
    */
    require_once("conn.php"); //connecting with DB
    
    try {
        $conn = new mysqli($host, $user, $pass, $db);
        $conn -> set_charset("utf8mb4");
    } catch(Exception $e) {
        error_log($e->getMessage());
        exit('Error connecting to database'); //Should be a message a typical user could understand
    }
    
    
    /*
    LANGUAGE
    */
    mysqli_query($conn,"SET NAMES 'utf8'");
    mysqli_query($conn,"SET NAMES `utf8` COLLATE `utf8_polish_ci`"); 
    header('Content-Type: text/html; charset=utf-8');


    /*
    DOWNLOAD FROM FORM
    */
    @$imie = str_replace(' ','',$_POST['imie']); 
    @$nazwisko = str_replace(' ','',$_POST['nazwisko']);
    @$email = str_replace(' ','',$_POST['email']);
    @$tel = str_replace(' ','',$_POST['tel']);
    @$ulica = str_replace(' ','',$_POST['ulica']);
    @$dom = str_replace(' ','',$_POST['dom']);
    @$lokal = str_replace(' ','',$_POST['lokal']);
    @$kod = str_replace(' ','',$_POST['kod']);
    @$miejscowosc = str_replace(' ','',$_POST['miejscowosc']);
    @$imie_dziecka = str_replace(' ','',$_POST['imie_dziecka']);
    @$rok_dziecka = str_replace(' ','',$_POST['rok_dziecka']);
    
    
    //check if data exist in DB
    @$row = $conn->prepare($conn,"SELECT `nazwisko`,`ulica`,`dom`,`lokal`,`miejscowosc` FROM `$table` WHERE `nazwisko` = '$nazwisko' AND `ulica` = '$ulica' AND `dom` = '$dom' AND `lokal` = '$lokal' AND `miejscowosc` = '$miejscowosc'"); 
    @$row->execute();

    function isEmpty($var){
        if(!empty($imie) && $imie!=" ")){
            return false;
        }
        else{
            return true;
        }
    }
    
    //ERROR if data exist in DB
    if($row["nazwisko"]==$nazwisko && $row["ulica"]==$ulica && $row["dom"]==$dom && $row["miejscowosc"]==$miejscowosc){
        echo "<div id='error'>Próbka już była wysłana</div>";
    }
    //next step if data not exist
    else{
        //if data inputs are not empty
        if((isEmpty($imie) && isEmpty($nazwisko) && isEmpty($email) && isEmpty($tel) && isEmpty($ulica) && isEmpty($dom) && isEmpty($kod) && isEmpty($miejscowosc)){
            
            echo ".";
            
            //if checkboxes are checked
            if(isset($_POST['check_fir']) && isset($_POST['check_sec'])){
                //checking data formating if is muber or txt
                if(is_numeric($imie) || is_numeric($nazwisko) || is_numeric($ulica) || is_numeric($miejscowosc) || is_numeric($imie_dziecka)){
                     echo "<div id='error'>Wprowadziłeś nieprawidłowy format danych</div>";
                }
                else{
                    mysqli_query($conn,"SET NAMES 'utf8'");  //language
                    mysqli_query($conn,"SET NAMES `utf8` COLLATE `utf8_polish_ci`"); 
                    
                    @$sql = $conn->prepare("INSERT INTO `$table` (imie, nazwisko, email, telefon, ulica, dom, lokal, kod, miejscowosc, imie_dziecka,rok_urodzenia_dziecka) VALUES ('$imie', '$nazwisko', '$email',$tel, '$ulica', '$dom', '$lokal', '$kod', '$miejscowosc','$imie_dziecka', '$rok_dziecka')";
                    
                    //INSERING INTO DB AND SHOW THANKS PAGE
                    if (@$sql->execute()) { 
                       echo '<meta http-equiv="refresh" content="1; URL=send.html" />';
                    }
                    //ERROR
                    else {
                        echo "<div id='error'>Błąd: " . $sql . "<br>" . mysqli_error($conn)."</div>"; 
                    }  
                }
            }
            //iuf checkboxes are nor checked
            else{
                echo "<div id='error'>Proszę zaakceptować regulamin i wyrazić zgodę</div>"; //jeżeli regulamin nie jest zaakaceptowany
            }
        }
        //if inputs are empty
        else{
            echo "<div id='error'>Wprowadziłeś złe dane</div>"; //jeżeli pola są puste
        }
    }
    //closing connection with DB
    mysqli_close($conn); 
}
?>