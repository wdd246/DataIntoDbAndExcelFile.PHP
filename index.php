<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <div id="form">
        <p id="info"></p>
        <form action="" method="post" onsubmit="checksub()"><br>
            <input type="text" id="imie" name="imie" placeholder="Imie" onblur="checktxt()" value="<?php //echo $_POST['imie'] ?>" required>
            <input type="text" id="nazwisko" name="nazwisko" placeholder="Nazwisko" onblur="checktxt()" value="<?php //echo $_POST['nazwisko'] ?>" required><br>
            <input type="email" id="email" name="email" placeholder="E-mail" value="<?php //echo $_POST['email'] ?>" required>
            <input name="tel" id="tel" placeholder="Telefon (+48)XXXXXXXXX" pattern="[0-9]{9}" value="<?php //echo $_POST['tel'] ?>" required><br>
            <input type="text" id="ulica" name="ulica" placeholder="Ulica" onblur="checktxt()" value="<?php //echo $_POST['ulica'] ?>" required>
            <input type="text" id="dom" name="dom" placeholder="Nr. domu" onblur="checktxt()" value="<?php //echo $_POST['dom'] ?>" required>
            <input type="text" id="lokal" name="lokal" placeholder="Nr. lokalu" onblur="checktxt()" value="<?php //echo $_POST['lokal'] ?>"><br>
            <input name="kod" id="kod" placeholder="Kod pocztowy XX-XXX" pattern="^[0-9]{2}-[0-9]{3}$" value="<?php //echo $_POST['kod'] ?>" required>
            <input type="text" id="miejscowosc" name="miejscowosc" placeholder="Miejscowość" onblur="checktxt()" value="<?php //echo $_POST['miejscowosc'] ?>" required><br>
            <input type="text" id="imie_dziecka" name="imie_dziecka" placeholder="Imię dziecka" onblur="checktxt()" value="<?php //echo $_POST['imie_dziecka'] ?>">
            <input name="rok_dziecka" id="rok_dziecka" placeholder="Data urodzin dziecka YYYY-MM-DD" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" value="<?php //echo $_POST['rok_dziecka'] ?>"><br>
            <input type="checkbox" name="check_fir" value="" checked> Zapoznałem/łam się z Regulaminem i akceptujęjego postanowienia <br>
            <input type="checkbox" name="check_sec" value="" checked> Wygrażam zgodę <br>
            <input type="checkbox" name="check_thr" value="" checked> Wyrażam zgodę <br>
            <button id="sub" name="sub" onclick="sub()">Zamów teraz</button>
        </form>
    </div>


    <?php
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ERROR | E_PARSE);
    
if(isset($_POST["sub"])){ // if submit button clicked
       
    require_once("conn.php"); //connecting with DB
    $conn = new mysqli($host, $user, $pass);
    mysqli_select_db($conn, $db);

    //Language
    mysqli_query($conn,"SET NAMES 'utf8'");
    mysqli_query($conn,"SET NAMES `utf8` COLLATE `utf8_polish_ci`"); 
    header('Content-Type: text/html; charset=utf-8');


    //Download from form
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
    @$sprawdzenie = mysqli_query($conn,"SELECT `nazwisko`,`ulica`,`dom`,`lokal`,`miejscowosc` FROM `$table` WHERE `nazwisko` = '$nazwisko' AND `ulica` = '$ulica' AND `dom` = '$dom' AND `lokal` = '$lokal' AND `miejscowosc` = '$miejscowosc'"); 
    @$row = mysqli_fetch_array($sprawdzenie);

    //ERROR if data exist in DB
    if($row["nazwisko"]==$nazwisko && $row["ulica"]==$ulica && $row["dom"]==$dom && $row["miejscowosc"]==$miejscowosc){
        echo "<div id='error'>Próbka już była wysłana</div>";
    }
    //next step if data not exist
    else{
        //if data inputs are not empty
        if((!empty($imie) && $imie!=" ") && (!empty($nazwisko) && $nazwisko!=" ") && (!empty($email) && $email!=" ") && (!empty($tel) && $tel!=" ") && (!empty($ulica) && $ulica!=" ") && (!empty($dom) && $dom!=" ") && (!empty($kod) && $kod!=" ") && (!empty($miejscowosc) && $miejscowosc!=" ")){
            
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
                    
                    @$sql = "INSERT INTO `$table` (imie, nazwisko, email, telefon, ulica, dom, lokal, kod, miejscowosc, imie_dziecka,                                   rok_urodzenia_dziecka) VALUES ('$imie', '$nazwisko', '$email',$tel, '$ulica', '$dom', '$lokal', '$kod', '$miejscowosc',                           '$imie_dziecka', '$rok_dziecka')";
                    
                    //INSERING INTO DB AND SHOW THANKS PAGE
                    if (mysqli_query($conn, $sql)) { 
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
</body>

</html>
