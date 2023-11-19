<!DOCTYPE html>
<html lang="pl-PL">
<?php
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</head>

<body style='height: 100vh' class='bg-secondary d-flex justify-content-center align-items-center'>
    <div class='d-flex bg-primary-subtle flex-column border rounded-3 border-4 border-primary p-3'>
        <form class='d-flex flex-column' method="POST" action="rejestrowanie.php">
            <input class='input-group-text m-1 text-start' placeholder='Login' type="text" name="Login" maxlength='16'>
            <input class='input-group-text m-1 text-start' placeholder='Hasło' type="password" name="Haslo"
                maxlength='16'>
            <input class='input-group-text m-1 text-start' placeholder='Powtórz hasło' type="password" name="PHaslo"
                maxlength='16'>
            <a href='index.php'>Masz już konto? Zaloguj się!</a>
            <input class='btn btn-primary m-1' type="submit" value="Zarejestruj" name='BTN'`````````````````>
        </form>
        <?php
        if(isset($_SESSION['blad_rejestracja'])){
            echo $_SESSION['blad_rejestracja'];
        }

    ?>
    </div>
</body>

</html>