<!DOCTYPE html>
<html lang="pl-PL" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS\style.css" rel="stylesheet">
    <link href="CSS\select2.min.css" rel="stylesheet">
    <title>Document</title>

</head>
<body>
    <div class="sprawdzanieKalendarza">
    <form method="POST" class="formularzKalendarz">
        Od: <input type="date" name="data">
        Do: <input type="date" name="drugaData">
        <div><input type="checkbox" name="czyDrugaData" onchange="ukryjInput()">
        <label for="czyDrugaData">Chcę sprawdzić jedną datę</label>
    </div>
        <input type="submit" value="Sprawdź" name="BTN">
    </form>
</div>
    <div class="kalendarz">
    <?php
    require 'mysql.php';
    require 'Zapytania.php';
    setlocale(LC_ALL, 'pl.UTF-8');
    error_reporting(E_ERROR | E_PARSE);
        $con = new mysqli($host, $uzytkownik, $haslo, $baza);
        if($con->connect_errno){
            echo "Błąd łączenia";
        }
        else{
            if(isset($_POST['BTN']) || (empty($_POST['data']) && empty($_POST['drugaData']))){
                if(!$_POST['czyDrugaData']){
                    if(( empty($_POST['data']) && !empty($_POST['drugaData'] )) || ( empty($_POST['drugaData']) && !empty($_POST['data']) )){
                        echo "Podaj obie daty!";
                    }
                    else if((empty($_POST['data']) || empty($_POST['drugaData']))){
                        generowanieKalendarza();
                    }
                    else if(isset($_POST['data']) && isset($_POST['drugaData'])){
                        $poniedzialekDaty = date("Y-m-d", strtotime(
                            'monday this week',
                            strtotime($_POST['data'])
                        ));
                        $j = 0;
                        for($i = 0; $i<=floor((strtotime($_POST['drugaData']) - strtotime($poniedzialekDaty))/(60*60*24)); $i++){
                            $zapytanie = $con->query($zapytanieKalendarz.modyfikacjaDaty($poniedzialekDaty, $j )."'");
                            if(mysqli_num_rows($zapytanie) == 0){
                                echo "<div class='blokKalendarza'><div class='data'>"
                                ,modyfikacjaDaty($poniedzialekDaty, $j),"<br>",
                                strftime('%A', strtotime(modyfikacjaDaty($poniedzialekDaty, $j))),
                                
                                "</div><div class='opis'>Brak zdarzeń w tym dniu</div></div>";
                            }
                            else{
                                echo "<div class='blokKalendarza'>";
                                echo "<div class='data'>",modyfikacjaDaty($poniedzialekDaty, $j), "<br>",
                                strftime('%A', strtotime(modyfikacjaDaty($poniedzialekDaty, $j))),"</div>";
                                while ($res = mysqli_fetch_assoc($zapytanie)){
                                    generujBlokKalendarza($res['ratownik'], $res['lekarz'], $res['dyspozytor'], $res['opis'], $res['id']);
                                }
                                echo "</div>";
                            }
                            $j++;
                        }
                    }
                }
                else if($_POST['czyDrugaData']){
                    if(empty($_POST['data'])){
                        echo "Podaj datę!";
                    }
                    else{
                        $zapytanie = $con->query($zapytanieKalendarz.$_POST['data']."'");
                        echo "<div class='blokKalendarza'>";
                        echo "<div class='data'>", $_POST['data'], "<br>", strftime('%A', strtotime($_POST['data'])),"</div>";
                         while($res = mysqli_fetch_assoc($zapytanie)){
                            generujBlokKalendarza($res['ratownik'], $res['lekarz'], $res['dyspozytor'], $res['opis'], $res['id']);
                         }
                         echo "</div>";
                    }
                }
                }
            }
    ?>
    </div>
    <div class='dodawanie'>
    <form method="POST" class="dodawanieFormularz">
    <table>
        <caption>DODAJ DYŻUR</caption>
        <tr><th>Data</th><th>Ratownik</th><th>Lekarz</th><th>Dyspozytor</th><th>Opis</th></tr>
        <tr>
        <td><input type="date" name="dataZdarzenia"></td>
        <td><select name="Ratownik">
            <?php
                $zapytanie = $con->query("SELECT id, imie, nazwisko FROM ratownicy");
                while($res = mysqli_fetch_assoc($zapytanie)){
                    echo "<option value=".$res['id'].">".$res['imie']." ".$res['nazwisko']."</option>";
                }
            ?>
        </select></td>
        <td><select name="Lekarz">
        <?php
                $zapytanie = $con->query("SELECT id, imie, nazwisko FROM lekarze");
                while($res = mysqli_fetch_assoc($zapytanie)){
                    echo "<option value=".$res['id'].">".$res['imie']." ".$res['nazwisko']."</option>";
                }
            ?>
        </td>
        <td><select name="Dyspozytor">
        <?php
                $zapytanie = $con->query("SELECT id, imie, nazwisko FROM dyspozytorzy");
                while($res = mysqli_fetch_assoc($zapytanie)){
                    echo "<option value=".$res['id'].">".$res['imie']." ".$res['nazwisko']."</option>";
                }
            ?></td>
        <td><input type="text" name="opis"></td>
        <td><input type="submit" name="dodaj" value="Dodaj"></td>
    </tr>
    </table>
            </div>
            </form>
            <form method="POST" action="" class="usuwanie">
                <input type="text" name="idDoUsuniecia" disabled hidden>
            </form>
    <?php
    if(isset($_POST['idDoUsuniecia'])){
        $con->query('DELETE FROM zgloszenia WHERE id = '. $_POST['idDoUsuniecia']);

    }
    ?>
    <?php
    if(isset($_POST['dodaj'])){
        if(empty($_POST['dataZdarzenia']) || empty($_POST['opis'])){
            echo "<p style='color:red'>Nie podano daty lub opisu zdarzenia!</p>";
        }
        else{
            // SPRAWDZANIE RATOWNIKA
            if(Sprawdzanie("ratownik", $_POST['Ratownik']) || Sprawdzanie("lekarz", $_POST['Lekarz'])){
                $nieDostepny = (Sprawdzanie("ratownik", $_POST['Ratownik']) == true ? "Ten ratownik nie jest w tym dniu dostępny!<br>" :"").(Sprawdzanie("lekarz", $_POST['Lekarz']) == true ? "Ten lekarz nie jest w tym dniu dostępny!" : "");
                echo "<p style='color:red; font-size:18pt'>".$nieDostepny."</p>";
            }
            else{
                $poniedzialekTygodnia = date("Y-m-d", strtotime(
                    'monday this week',
                    strtotime($_POST['dataZdarzenia'])
                ));
                $niedzielaTygodnia = date("Y-m-d", strtotime(
                    'sunday this week',
                     strtotime($_POST['dataZdarzenia'])
                ));
                    $ilePracowalWTydzien = mysqli_num_rows($con->query(zapytanieSprawdzania("dyspozytor", $_POST['Dyspozytor'], $poniedzialekTygodnia, true, $niedzielaTygodnia)));
                    $czyPrzepracowalLimitWCiaguTygodnia = $ilePracowalWTydzien < 6 ? false :  true;
                    if($czyPrzepracowalLimitWCiaguTygodnia){
                        echo "p style='color:red; font-size:18pt'>Ten dyspozytor nie jest dostępny!</p>";
                    }
                    else{
                        $con->query("INSERT INTO zgloszenia(id, dataZdarzenia, zgloszenie_ratownik, zgloszenie_lekarz, zgloszenie_dyspozytor, opis) VALUES(NULL,'". $_POST['dataZdarzenia']."', ".$_POST['Ratownik'].", ".$_POST['Lekarz'].", ".$_POST['Dyspozytor'].", '".$_POST['opis']."')");
                        echo "Dyżur został dodany!";
                
                    }
            }
        }
    }
    ?>
    <?php
            function modyfikacjaDaty($data, $ileDni){
                $dataTydzien = date_create($data);
                date_add($dataTydzien, date_interval_create_from_date_string($ileDni.'days'));
                return date_format($dataTydzien, "Y-m-d");
            }
            function zapytanieSprawdzania($kogo, $idKogo, $jakaData, $pomiedzy = false, $jakaDrugaData = ''){
                $zgloszenieKogo = "zgloszenie_$kogo";
                if(!$pomiedzy){
                    return "SELECT $zgloszenieKogo FROM zgloszenia WHERE $zgloszenieKogo = $idKogo AND dataZdarzenia = '$jakaData'";
                }
                else{
                    return "SELECT $zgloszenieKogo FROM zgloszenia WHERE $zgloszenieKogo = $idKogo AND dataZdarzenia BETWEEN '$jakaData' AND '$jakaDrugaData'";
                }

            }
            function Sprawdzanie($kogo, $idKogo){
                $con = new mysqli('localhost', 'root', '', 'SOR2');
                $poniedzialekTygodnia = date("Y-m-d", strtotime(
                    'monday this week',
                    strtotime($_POST['dataZdarzenia'])
                ));
                $niedzielaTygodnia = date("Y-m-d", strtotime(
                    'sunday this week',
                     strtotime($_POST['dataZdarzenia'])
                ));
                $czyPracowalDzienPrzed = mysqli_num_rows($con->query(zapytanieSprawdzania($kogo, $idKogo, modyfikacjaDaty($_POST['dataZdarzenia'], -1))));
                $czyPracowalDzienPo = mysqli_num_rows($con->query(zapytanieSprawdzania($kogo, $idKogo, modyfikacjaDaty($_POST['dataZdarzenia'], 1))));
                $czyPracowalWTenSamDzien = mysqli_num_rows($con->query(zapytanieSprawdzania($kogo, $idKogo, $_POST['dataZdarzenia'])));
                $ilePracowalWTydzien = mysqli_num_rows($con->query(zapytanieSprawdzania($kogo, $idKogo, $poniedzialekTygodnia, true, $niedzielaTygodnia)));
                $czyWystepuje = ($czyPracowalDzienPrzed + $czyPracowalWTenSamDzien + $czyPracowalDzienPo)  == 0 ? false : true;
                $czyPrzepracowalLimitWCiaguTygodnia = $ilePracowalWTydzien < 3 ? false :  true;
                return ($czyWystepuje || $czyPrzepracowalLimitWCiaguTygodnia);
            }
            function generowanieKalendarza(){
                require 'Zapytania.php';
                $con = new mysqli('localhost', 'root', '', 'SOR2');
                $zapytanie = $con->query("SELECT zgloszenia.dataZdarzenia from zgloszenia order by dataZdarzenia ASC LIMIT 1");
                $poczatkowaData = "";
                while($res = mysqli_fetch_assoc($zapytanie)){
                    $poczatkowaData = date('Y-m-d', strtotime($res['dataZdarzenia']));
                };
                $poczatkowaData = date("Y-m-d", strtotime(
                    'monday this week',
                    strtotime($poczatkowaData)
                ));
                $j = 0;
                for($i = 0; $i<=30; $i++){
                    $zapytanie = $con->query($zapytanieKalendarz.modyfikacjaDaty($poczatkowaData, $j )."'");
                    if(mysqli_num_rows($zapytanie) == 0){
                        echo "<div class='blokKalendarza'><div class='data'>"
                        ,modyfikacjaDaty($poczatkowaData, $j),"<br>",
                        strftime('%A', strtotime(modyfikacjaDaty($poczatkowaData, $j))),
                        "</div><div class='opis'>Brak zdarzeń w tym dniu</div></div>";
                    }
                    else{
                        echo "<div class='blokKalendarza'>";
                        echo "<div class='data'>"
                        ,modyfikacjaDaty($poczatkowaData, $j), "<br>",
                        strftime('%A', strtotime(modyfikacjaDaty($poczatkowaData, $j))),
                        "</div>";
                        while ($res = mysqli_fetch_assoc($zapytanie)){
                            generujBlokKalendarza($res['ratownik'], $res['lekarz'], $res['dyspozytor'], $res['opis'], $res['id']);
                            
                        }
                        echo "</div>";
                    }
                    $j++;
                }
            }
            function generujBlokKalendarza($ratownik, $lekarz, $dyspozytor, $opis, $id){
                echo "<div class='opis'>
                <h5>ZDARZENIE</h5>
                <h6>Ratownik</h6>"
                     , $ratownik ,
                     "<h6>Lekarz</h6>"
                     , $lekarz ,
                     "<h6>Dyspozytor</h6>"
                     , $dyspozytor ,
                     "<h6>Opis</h6>"
                     , $opis ,
                     "<input type='button' value='Usun' id='", $id ,"' onclick='zmienInputUsun(this.id)'>",
                     "</div>";

            }
            $con->close();
    ?>
</body>
<script src="Skrypty\jquery.js"></script>
<script src="Skrypty\select2.min.js"></script>
<script src="Skrypty\skrypt.js"></script>
</html>

