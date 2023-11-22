<?php
    define('__ROOT__', dirname(dirname(__FILE__)));
    require_once(__ROOT__.'/WebProject/database.php');
    session_start();

    //If no session is set we get a wrong access to the page
    if (!isset($_SESSION['id'])) {
        $_SESSION['msg'] = "You have to log in first";
        header('location: /WebProject/index.php');
    }

    //if he is not a seller, no access
    if($_SESSION['role'] != 'PRODUCTSELLER'){
        header('location: /WebProject/noAccess.php');    
    } 

    //TODO Add checks for compatability with the database
    if(!empty($_POST['name']) && !empty($_POST['code']) && !empty($_POST['price'])&& !empty($_POST['category']) ){
        $name=$_POST['name'];
        $code=$_POST['code'];
        $price=$_POST['price'];
        $category=$_POST['category'];
        $sellerName = $_SESSION['name'];
        
        $query = "INSERT INTO products (NAME, PRODUCTCODE, PRICE,SELLERNAME,CATEGORY) VALUES (?,?,?,?,?)";
        try{
            $stmt = $conn->prepare($query);
            $stmt->execute([$name,$code,$price,$sellerName,$category]);
        }catch(PDOException $e){
            echo("Error " . e->getCode() );
        }    
        
       header('location: /WebProject/seller.php');
    }else{
        
    }
?>

<!DOCTYPE html>
<htlm lang="en">
    <head>
        <meta charset="UTF-8" />
        <title> This is a site </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel = "stylesheet" href="addProductStyle.css">
        
    </head>
    
    <body>
        <div class="add-card">
            <div class="add-card-form">
                <form method = "POST" action = "#">          
                    <div class="form-input">
                        <h2>Add a Product</h2>
                        
                        <span>Name</span>
                        <input type="text" name="name" required/>                    
                    </div>

                    <div class="form-input">
                        <span>Product code</span>
                        <input type="text" name="code" required/>
                    </div>

                    <div class="form-input">
                        <span>Price</span>
                        <input type="number" name="price" required/>
                    </div>

                    <div class="form-input">
                        <span>Category</span>
                        <input type="text" name="category" required/>                      
                    </div>
                    
                    <input type="submit" name="submit" value = "Add" class="addBtn"/>
                    <input type="button" onclick="toSeller()" value = "Cancel" class="cancelBtn">
                </form>
            </div>
            
            <script type="text/javascript" src="js/script.js"></script>
        </div>       
    </body>
<htlm>