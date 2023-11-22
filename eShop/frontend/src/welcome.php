<?php
    /* if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location: /WebProject/index.php' ));
    } */

    session_start();
    
    //If no session is set we get a wrong access to the page
    //Wrong access can be a direct link for example
    if (!isset($_SESSION['id'])) {
        $_SESSION['msg'] = "You have to log in first";
        header('location: /WebProject/index.php');
    }
    
    //When the logout button is pressed destroy the session and head back to index
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['id']);
        header("location: /WebProject/index.php");
    }

?>

<!DOCTYPE html>
<htlm lang="en">
    <head>
        <meta charset="UTF-8" />
        <title> This is a site </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel = "stylesheet" href="welcomeStyle.css">
        
    </head>
    
    <body>
        <div class="petekapebar-header">
            <div class="petekapebar-left-content">
                <button class="dropDownBtn">Menu</button>
                <div class="dropDown-content">
                    <a href="/WebProject/products.php">Products</a>
                    <a href="/WebProject/cart.php">Cart</a>
                    <a href="/WebProject/seller.php">Seller</a>
                    <a href="/WebProject/administration.php">Administration</a>
                </div> 
            </div>  
            
            <div class="petekapebar-right-content"> 
                <h3><?php echo $_SESSION['name']." ".$_SESSION['surname']?></h3>
            </div>
        </div>
        
        <div class="logout">
            <a href="welcome.php?logout='1'">
                Logout
            </a>
        </div> 
        
        <script type="text/javascript" src="js/script.js"></script>
    </body>
<htlm>