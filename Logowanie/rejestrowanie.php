<?php
    session_start();
    $con = new mysqli('localhost', 'root', '', 'uzytkownicy');
    if ($con->connect_errno) {
        echo "Błąd!: " . $con->connect_error;
        exit();
     }
    if(isset($_POST['BTN'])){
        $stmt = $con->prepare('SELECT id FROM uzytkownicy WHERE login = ?');
        $stmt->bind_param('s', $login);
    
        $login = $_POST['Login'];
    
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id);
        if(empty($_POST['Haslo']) || empty($_POST['Login'])){
            $_SESSION['blad_rejestracja'] = "<p class='fw-bold text-danger'>Uzupełnij wszystkie pola!</p>";
            header("Location: rejestracja.php");
        }
        else{
            if($stmt->num_rows != 0){
                $_SESSION['blad_rejestracja'] = "<p class='fw-bold text-danger'>Login jest już zajęty!</p>";
                header("Location: rejestracja.php");
            }
            else{
                if($_POST['Haslo'] == $_POST['PHaslo']){
                    $stmt = $con->prepare('INSERT INTO uzytkownicy(id, login, haslo) VALUES(NULL, ?, ?)');
                    $stmt->bind_param('ss', $Login, $Haslo);
            
                    $Login = $_POST['Login'];
                    $Haslo = HASH('sha256', $_POST['Haslo']);
            
                    $stmt->execute() ? $_SESSION['Info'] = "<p class='fw-bold text-success'>Konto zostało utworzone!<br>Możesz się zalogować.</p>" : $_SESSION['Info'] = "<p class='fw-bold text-danger'>Przy rejestracji wystąpił błąd!</p>";
        
                    header("Location: index.php");
                    unset($_SESSION['blad_rejestracji']);
                }
                else{
                    $_SESSION['blad_rejestracja'] = "<p class='fw-bold text-danger'>Hasła się nie zgadzają!</p>";
                    header("Location: rejestracja.php");
                }
            }
        }
        $con->close();
    }

?>