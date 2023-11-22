<?php
     //Get the database connection
    define('__ROOT__', dirname(dirname(__FILE__)));
    require_once(__ROOT__.'/WebProject/database.php');

    session_start();
    
    //If no session is set we get a wrong access to the page
    if (!isset($_SESSION['id'])) {
        $_SESSION['msg'] = "You have to log in first";
        header('location: /WebProject/index.php');
    }

    //if its not a user he should not have access
    if($_SESSION['role'] != 'USER'){
        header('location: /WebProject/noAccess.php');    
    } 

    if (isset($_POST['remove'])) {
        $pid = $_POST['productID'];
        $query = "DELETE FROM carts WHERE PRODUCTID= :pid LIMIT :limit"; 
        $stmt = $conn->prepare($query);
        $stmt->bindParam('pid',$pid,PDO::PARAM_STR);
        $limit = 1;
        $stmt->bindParam('limit',$limit,PDO::PARAM_INT);
        if($stmt->execute()){
            
        }
    }
    
    $uid=$_SESSION['userid'];

    $cartList=array(); //list used to find all the user carts, in order to find all the products
    $prodList=array(); //list used to find all the product information
    //list containing the date of insertion to the cart of everyproducts
    $doiList=array();
    $num=0;
    $totalPrice=0;;
    //Find all the carts the user has in order to get the products
    $query = "SELECT * FROM carts WHERE USERID= :uid "; 
    $stmt = $conn->prepare($query);
    $stmt->bindParam('uid',$uid,PDO::PARAM_STR);
    if($stmt->execute()){
        $result = $stmt->fetchAll();
         //get all the carts that include the user's products
        foreach($result as $row){
            $cartList[] = $row;
            $doiList[] = $row['DATEOFINSERTION'];
        }
        
        //Get all the product that are in the cart information
        foreach($cartList as $prod){
            $pid = $prod['PRODUCTID'];
            $query = "SELECT * FROM products WHERE ID= :pid "; 
            $stmt = $conn->prepare($query);
            $stmt->bindParam('pid',$pid,PDO::PARAM_STR);
            
            if($stmt->execute()){
                $res = $stmt->fetchAll();
                foreach($res as $pro){
                    $prodList[] = $pro;
                    $totalPrice = $totalPrice + $pro['PRICE'];
                }
        }
        }
    }


?>

<!DOCTYPE html>
<htlm lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title> This is a site </title>   
        <link rel="stylesheet" href="cartStyle.css"/>    
    </head>
    
    <body>
         <div class="container">
             <div class="container-box">
                <form method="POST" action = "#" >
                    <h1>Your Cart</h1>
                    <div class="products">
                        <?php  
                            foreach($prodList as $temp){     
                        ?>
                            <h5 class="text">Product name: &nbsp;<?= $temp['NAME']; ?></h5>
                            <h5 class="text">Product price: &nbsp;<?= $temp['PRICE']; ?></h5>
                            <h5 class="text">Date of insertion to cart: &nbsp;<?= $doiList[$num]; ?></h5>

                            <input type="hidden" name="productID" value="<?= $temp['ID'] ?>">
                            <input type="submit" name="remove" value ="Remove" class="removeBtn"/>

                        <?php $num++; }?>
                    </div>
                    
                    <h5 class="totalPrice">Total price: <?= $totalPrice; ?></h5>

                    <div class="form-other">
                        <input type = "button" onclick="toWelcome()" value = "Return" class="returnBtn">              
                    </div>      
                </form>
             </div>       
        </div>
        <script type="text/javascript" src="js/script.js"></script>
    </body>
<htlm>