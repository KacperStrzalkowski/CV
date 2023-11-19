<?php
        session_start();
        $_SESSION['zalogowany'] == true ? "" : header("Location: index.php");
    ?>
<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST">
        <input type="submit" value="Wyloguj" name="BTN">
    </form>
    <?php
        if(isset($_POST['BTN'])){
            $_SESSION['zalogowany'] = false;
            header("Location: index.php");
        }
    ?>
</body>

</html>