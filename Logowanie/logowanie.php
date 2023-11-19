<?php
    session_start();
    header("Location: index.php");
    $con = new mysqli('localhost', 'root', '', 'uzytkownicy');
    if ($con->connect_errno) {
        echo "Błąd!: " . $con->connect_error;
        exit();
     }
    $stmt = $con->prepare("SELECT id FROM uzytkownicy WHERE login = ? AND haslo = ?");
    $stmt->bind_param("ss", $Login, $Haslo);

    $Login = $_POST['Login'];
    $Haslo = HASH('sha256', $_POST['Haslo']);

    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id);

    if($stmt->num_rows == 0){
        $_SESSION['blad_logowanie'] = "<p class='fw-bold text-danger'>Podano błędny login lub hasło!</p>";
    }
    else{
        unset($_SESSION['Info']);
        unset($_SESSION['blad_rejestracja']);
        unset($_SESSION['blad_logowanie']);
        $_SESSION['zalogowany'] = true;
    }
?>