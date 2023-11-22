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


    $list=array();

    //When the search button is pressed empty the list of all the products
    if (isset($_GET['search'])) {
        unset($list); //delete the list
        $list=array(); //reinstansiate the list
    }

    //If the user entered a product name, fetch all products with that name
    if(!empty($_POST['product_Name'])) {
        $pname = $_POST['product_Name'];
        $query = "SELECT * FROM products WHERE NAME= :name "; 
        $stmt = $conn->prepare($query);
        $stmt->bindParam('name',$pname,PDO::PARAM_STR);
        if($stmt->execute()){
            $result = $stmt->fetchAll();
            foreach($result as $row){
                $list[] = $row;
            }
        }
    }else if(!empty($_POST['product_Category'])){ //If the user entered a product's category, fetch all sellers with that name
        $cate = $_POST['product_Category'];
        $query = "SELECT * FROM products WHERE CATEGORY= :category "; 
        $stmt = $conn->prepare($query);
        $stmt->bindParam('category',$cat,PDO::PARAM_STR);
        if($stmt->execute()){
            $result = $stmt->fetchAll();
            foreach($result as $row){
                $list[] = $row;
            }
        }
    }else if(!empty($_POST['product_Price'])){ //If the user entered a product's price, fetch all sellers with that name
        $price = $_POST['product_Price'];
        $query = "SELECT * FROM products WHERE PRICE= :price ";  
        $stmt = $conn->prepare($query);
        $stmt->bindParam('price',$price,PDO::PARAM_STR);
        if($stmt->execute()){
            $result = $stmt->fetchAll();
            foreach($result as $row){
                $list[] = $row;
            }
        }
    }else if(!empty($_POST['product_Date'])){ //If the user entered a product's date of withdrawal, fetch all sellers with that name
        $date = $_POST['product_Date'];
        $query = "SELECT * FROM products WHERE DATEOFWITHDRAWAL= :date "; 
        $stmt = $conn->prepare($query);
        $stmt->bindParam('date',$date,PDO::PARAM_STR);
        if($stmt->execute()){
            $result = $stmt->fetchAll();
            foreach($result as $row){
                $list[] = $row;
            }
        }
    }else if(!empty($_POST['seller_Name'])){ //If the user entered a seller's name, fetch all sellers with that name
        $sname = $_POST['seller_Name'];
        $role = 'PRODUCTSELLER';
        $query = "SELECT * FROM users WHERE ROLE= :role AND NAME= :name "; 
        $stmt = $conn->prepare($query);
        $stmt->bindParam('role',$role,PDO::PARAM_STR);
        $stmt->bindParam('name',$sname,PDO::PARAM_STR);
        if($stmt->execute()){
            $result = $stmt->fetchAll();
            foreach($result as $row){
                $list[] = $row;
            }
        }
    }else if(!empty($_POST['seller_Username'])){ //If the user entered a seller's username, fetch all sellers with that username
        $sname = $_POST['seller_Username'];
        $role = 'PRODUCTSELLER';
        $query = "SELECT * FROM users WHERE ROLE= :role AND USERNAME= :name ";  
        $stmt = $conn->prepare($query);
        $stmt->bindParam('role',$role,PDO::PARAM_STR);
        $stmt->bindParam('name',$sname,PDO::PARAM_STR);
        if($stmt->execute()){
            $result = $stmt->fetchAll();
            foreach($result as $row){
                $list[] = $row;
            }
        }
    }else{
        $query = "SELECT * FROM products"; 
        $stmt = $conn->prepare($query);
        if($stmt->execute()){
            $result = $stmt->fetchAll();
            foreach($result as $row){
                $list[] = $row;
            }
        }
    }

    //When the add to cart button is pressed create a cart with the product id and the user id
    if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['prodID']) && !empty($_POST['add_to_cart'])) {
        $uid=$_SESSION['userid'];
        $pid=$_POST['prodID'];
        $query = "INSERT INTO carts (USERID, PRODUCTID) VALUES (?,?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$uid,$pid]);
       
    }

?>


<!DOCTYPE html>
<htlm lang="en">
    <head>
        <meta charset="UTF-8" />
        <title> This is a site </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel = "stylesheet" href="productsStyle.css">
    </head>
    
    <body>
        
        <div class="container">
            <div class="left-content">
                <?php  
                    foreach($list as $temp){
                ?>
                <div class=products_Header>
                    <form method="POST" action = "#" >
                        <h3 class="text-center">Product name: &nbsp; <?= $temp['NAME']; ?></h3>
                        <h3 class="text-center">Price: &nbsp;<?= $temp['PRICE']; ?></h3>
                        
                        <input type= "hidden" name="prodID" value="<?= $temp['ID'] ?>">
                        <input type="submit" name="add_to_cart" value ="Add To Cart" class="CartSearchBtn"/> 
                        
                    </form>
                </div>
                <?php }?>
            </div>
            
            <div class="right-content">
                <div class="search-card">
                    <div class="search-card-form">
                        <form method = "POST" action = "#">          
                            <div class="form-input">
                                <h2>Search</h2>

                                <input type="text" name="product_Name"/>
                                <span>Product Name:</span>
                                <i></i>
                            </div>
                    
                            <div class="form-input">
                                <input type="text" name="product_Category"/>
                                <span>Product Category:</span>
                                <i></i>
                            </div>

                            <div class="form-input">
                                <input type="text" name="product_Price"/>
                                <span>Product Price:</span>
                                <i></i>
                            </div>

                            <div class="form-input">
                                <input type="text" name="product_Date"/>
                                <span>Product Date Of Withdrawal:</span>
                                <i></i>
                            </div>

                            <div class="form-input">
                                <input type="text" name="seller_Name"/>
                                <span>Seller Name:</span>
                                <i></i>
                            </div>

                            <div class="form-input">
                                <input type="text" name="seller_Username"/>
                                <span>Seller Username:</span>
                                <i></i>
                            </div>      
                            <input type="submit" name="search" value = "search" class="searchBtn"/>
                            
                            <div class="form-other">
                                <input type = "button" onclick="toWelcome()" value = "Return" class="returnBtn">             
                                <input type = "button" onclick="toCart()" value = "Cart" class="cartBtn"> 
                            </div>
                            
                        </form>
                    </div>     
                </div>
            </div>
        </div>            
        <script type="text/javascript" src="js/script.js"></script>
    </body>
<htlm>