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
    
    //if he is not a seller, no access
    if($_SESSION['role'] != 'PRODUCTSELLER'){
        header('location: /WebProject/noAccess.php');    
    } 

    $pid = $_SESSION['prodID'];

    $query = "SELECT * FROM products WHERE ID= :pid";
    $stmt = $conn->prepare($query);
    $stmt->bindParam('pid',$pid,PDO::PARAM_STR);
    if($stmt->execute()){
        $result = $stmt->fetch();
    }

    $pName = $_POST['name'] ?? $result['NAME'];
    $pCode = $_POST['code'] ?? $result['PRODUCTCODE'];
    $pPrice = $_POST['price'] ?? $result['PRICE'];
    $pCateg = $_POST['category'] ?? $result['CATEGORY'];

    if(isset($_POST['edit'])) {

        if($result['NAME'] != $_POST['name']){
            $query = "UPDATE products SET NAME= :name WHERE ID= :pid";
            $stmt = $conn->prepare($query);
            $stmt->bindParam('pid',$pid,PDO::PARAM_STR);
            $temp = $_POST['name'];
            $stmt->bindParam('name',$temp,PDO::PARAM_STR);
            try{
                $stmt->execute();
            }catch(PDOException $e){
                echo("Error " . e->getCode() );
            }
        }
        
        if($_POST['code'] != $result['PRODUCTCODE']){
            $query = "UPDATE products SET PRODUCTCODE= :code WHERE ID= :pid";
            $stmt = $conn->prepare($query);
            $stmt->bindParam('pid',$pid,PDO::PARAM_STR);
            $temp = $_POST['code'];
            $stmt->bindParam('code',$temp,PDO::PARAM_STR);
            try{
                $stmt->execute();
            }catch(PDOException $e){
                echo("Error " . e->getCode() );
            }
        }
        if($_POST['price'] != $result['PRICE']){
            $query = "UPDATE products SET PRICE= :price WHERE ID= :pid";
            $stmt = $conn->prepare($query);
            $stmt->bindParam('pid',$pid,PDO::PARAM_STR);
            $temp = $_POST['price'];
            $stmt->bindParam('price',$temp,PDO::PARAM_STR);
            try{
                $stmt->execute();
            }catch(PDOException $e){
                echo("Error " . e->getCode() );
            }
        }
        if($_POST['category'] != $result['CATEGORY']){
            $query = "UPDATE products SET CATEGORY= :cat WHERE ID= :pid";
            $stmt = $conn->prepare($query);
            $stmt->bindParam('pid',$pid,PDO::PARAM_STR);
            $temp = $_POST['category'];
            $stmt->bindParam('cat',$temp,PDO::PARAM_STR);
            try{
                $stmt->execute();
            }catch(PDOException $e){
                echo("Error " . e->getCode() );
            }
        } 
         
        header('location: /WebProject/seller.php');
    }

?>

<!DOCTYPE html>
<htlm lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title> This is a site </title>   
        <link rel="stylesheet" href="editProductStyle.css"/>    
    </head>
    
    <body>
        <div class="product-card"> 
            <div class="product-card-form">
                <form method="POST" action = "#" >         
                    <div class="form-input">
                        <h2>Edit Product</h2>                        
                        <input type="text" name="name" value="<?=$pName?>"/>
                    </div>

                    <div class="form-input">
                        <input type="text" name="code" value="<?=$pCode?>"/>
                    </div>

                    <div class="form-input">
                        <input type="text" name="price" value="<?=$pPrice?>"/>
                    </div>

                    <div class="form-input">
                        <input type="text" name="category" value="<?=$pCateg?>"/>
                    </div>

                    <input type="submit" name="edit" value ="Save Changes" class="editBtn"/>

                    <div class="form-other">
                        <input type = "button" onclick="toSeller()" value = "Cancel" class="cancelBtn">                          
                    </div>
                </form>
            </div>
        </div>
       
        <script type="text/javascript" src="js/script.js"></script>
    </body>
<htlm>