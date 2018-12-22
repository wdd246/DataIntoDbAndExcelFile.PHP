<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Formularz</title>
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
include 'main.php'
?>
</body>

</html>
