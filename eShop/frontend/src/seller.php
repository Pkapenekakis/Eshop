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

    $sellerName = $_SESSION['name'];

    if (isset($_POST['remove'])) {
        $pid = $_POST['productID'];
        //seller name is not required added for extra security
        $query = "DELETE FROM products WHERE ID= :pid AND SELLERNAME= :selName LIMIT :limit"; 
        $stmt = $conn->prepare($query);
        $stmt->bindParam('pid',$pid,PDO::PARAM_STR);
        $stmt->bindParam('selName',$sellerName,PDO::PARAM_STR);
        $limit = 1;
        $stmt->bindParam('limit',$limit,PDO::PARAM_INT);
        if($stmt->execute()){
            
        }
    }

    $list = array();

    $query = "SELECT * FROM products WHERE SELLERNAME= :selName";
    $stmt = $conn->prepare($query);
    $stmt->bindParam('selName',$sellerName,PDO::PARAM_STR);
    if($stmt->execute()){
        $result = $stmt->fetchAll();
        foreach($result as $row){
            $list[] = $row;
        }
    }

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['edit'])) {
        $_SESSION['prodID'] = $_POST['productID']; 
        header('location: /WebProject/editProduct.php');
    }

?>

<!DOCTYPE html>
<htlm lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title> This is a site </title>   
        <link rel="stylesheet" href="sellerStyle.css"/>    
    </head>
    
    <body> 
        <table class="content-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Product Code</th>
                    <th>Price</th>
                    <th>Date Of Withdrawal</th>
                    <th>Seller's Name</th>
                    <th>Category</th>
                </tr>
            </thead>
            
            <tbody>
                <form method="POST" action = "#" >
                    <?php  
                        foreach($list as $temp){    
                    ?>
                    <tr>
                        <td><?= $temp['NAME']; ?></td>
                        <td><?= $temp['PRODUCTCODE']; ?></td>     
                        <td><?= $temp['PRICE']; ?></td>     
                        <td><?= $temp['DATEOFWITHDRAWAL']; ?></td>    
                        <td><?= $temp['SELLERNAME']; ?></td>     
                        <td><?= $temp['CATEGORY']; ?></td>

                        <td><input type="hidden" name="productID" value="<?= $temp['ID'] ?>"></td>
                        <td><input type="submit" name="edit" value ="Edit Product" class="editBtn"/></td>
                        <td><input type="submit" name="remove" value ="Remove Product" class="removeBtn"/></td>
                    </tr>
                    <?php }?>
                </form>
            </tbody>
        </table>
        <input type = "button" onclick="toWelcome()" value = "Return" class="returnBtn">              
        <input type = "button" onclick="toAddProduct()" value = "Add Product" class="addProductBtn">
        
        <script type="text/javascript" src="js/script.js"></script>
    </body>
<htlm>