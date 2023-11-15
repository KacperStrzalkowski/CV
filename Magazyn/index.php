<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
<div id="formularze">
            <form method="post">
                    <input type="text" name="rzecz" placeholder="Rzecz do wykonania...">
                    <input type="text" name="data" placeholder="Do kiedy...">
                    <input type="submit" name="przycisk" value="Dodaj do listy">
            </form>
            <form method="post">
                    <input type="text" name="id" placeholder="ID zadania...">
                    <input type="submit" name="przycisku" value="Usuń z listy">
            </form><br>
        </div>
        <?php
    require_once "ms.php";
    mysqli_report(MYSQLI_REPORT_OFF); //Wyłączenie fatal errorów
    $con= @new mysqli($host, $db_user, $db_pass, $db_name); // połączenie 
    
    if ($con->connect_errno!=0) //sprawdzanie błędu
    {
        echo "Błąd: " .$con->connect_errno; //kod błędu
    } 
    else 
    {
            if (isset($_POST['przycisk'])) {
                $rzecz=$_POST['rzecz'];
                $data=$_POST['data'];
                $rzecz = htmlentities($rzecz, ENT_QUOTES, "UTF-8");
                $data = htmlentities($data, ENT_QUOTES, "UTF-8"); // encje (żeby nie pierdolil sie skrypt)
                if (empty($rzecz)) {
                    echo "<a>Pola nie mogą być puste!</a>";
                } else {
                    if ($rez = $con->query(sprintf("SELECT * FROM rzeczy WHERE rzeczy='$rzecz'"))) {
                        $rek = $rez->num_rows; // Ile jest rezultatów;
                        if ($rek == 1) {
                            echo '<a>Już istnieje takie zadanie!</a>';
                        } else {
                            $con->query("INSERT INTO rzeczy(id, rzeczy, data) values(null, '$rzecz', '$data')");
                        }
                    }
                }
            }
            else if(isset($_POST['przycisku']))
            {
                $id = $_POST['id'];
                if(empty($id))
                {
                    echo "<a>Pola nie mogą być puste!</a>";
                }
                else
                {
                    $con->query("DELETE FROM rzeczy WHERE id='$id'");
                }
            }
            echo '<table>';
            echo '<tr><th>Numer</th><th>Zadanie</th><th>Do kiedy</th></tr>';
                $lista = $con->query("SELECT * from rzeczy");
                    while ($lista_elementy = mysqli_fetch_array($lista)) {
                        echo '<tr><td>' .$lista_elementy['id'].'</td><td>' .$lista_elementy['rzeczy'].'</td><td>' . $lista_elementy['data'] . '</tr>';
                    }
                    echo '</table>';

        $con->close(); // zamknięcie połączenia
    }
    ?>
</body>
</html>