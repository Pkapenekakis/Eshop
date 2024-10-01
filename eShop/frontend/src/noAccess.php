<?php
    session_start();

    if (!isset($_SESSION['id'])) {
        $_SESSION['msg'] = "You have to log in first";
        header('location: /index.php');
    }

?>


<!DOCTYPE html>
<htlm lang="en">
    <head>
        <meta charset="UTF-8" />
        <title> This is a site </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel = "stylesheet" href="noAccess.css">
        <link rel = "stylesheet" href="noAccessStyle.css">
    </head>
    
    <body>
        <h1>You do not have Access to the page</h1>
        <input type = "button" onclick="toWelcome()" value = "Return" class="returnBtn">             
        <script type="text/javascript" src="js/script.js"></script>
    </body>
<htlm>
