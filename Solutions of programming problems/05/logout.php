<?php
    session_start();

    $_SESSION['enter'] = false; // we set it default value
    $_SESSION['userId'] = '';
    $_SESSION['username'] = '';
    $_SESSION['msg'] = 'Please log in!';
    $_SESSION['msgType'] = 'info';
    unset($_SESSION['number']);

    header("Location: ./index.php");
?>