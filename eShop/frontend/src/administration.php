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
    
    //if he is not an admin, no access
    if($_SESSION['role'] != 'ADMIN'){
        header('location: /WebProject/noAccess.php');    
    }


    if (isset($_POST['remove'])) {
        $uid = $_POST['userID'];
        //seller name is not required added for extra security
        $query = "DELETE FROM users WHERE ID= :uid"; 
        $stmt = $conn->prepare($query);
        $stmt->bindParam('uid',$uid,PDO::PARAM_STR);
        
        try{
            $stmt->execute();
        }catch(PDOException $e){
            echo("Error " . e->getCode() );
        }
    }

    $list = array();

    $query = "SELECT * FROM users";
    $stmt = $conn->prepare($query);
    if($stmt->execute()){
        $result = $stmt->fetchAll();
        foreach($result as $row){
            $list[] = $row;
        }
    }

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['edit'])) {
        $_SESSION['userID'] = $_POST['userID']; 
        header('location: /WebProject/editUser.php');
    }

?>

<!DOCTYPE html>
<htlm lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title> This is a site </title>   
        <link rel="stylesheet" href="adminStyle.css"/>    
    </head>
    
    <body>
        
        <table class="content-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Confirmed</th>
                </tr>
            </thead>
            
            <tbody>
                <form method="POST" action = "#" >
                    <?php  
                        foreach($list as $temp){    
                    ?>
                    <tr>
                        <td><?= $temp['ID']; ?></td>
                        <td><?= $temp['NAME']; ?></td>
                        <td><?= $temp['SURNAME']; ?></td>     
                        <td><?= $temp['USERNAME']; ?></td>     
                        <td><?= $temp['EMAIL']; ?></td>     
                        <td><?= $temp['ROLE']; ?></td>     
                        <td><?= $temp['CONFIRMED']; ?></td>
                        <td><input type="hidden" name="userID" value="<?= $temp['ID'] ?>"> </td>
                        <td><input type="submit" name="edit" value ="Edit User" class="editBtn"/></td>
                        <td><input type="submit" name="remove" value ="Delete User" class="removeBtn"/></td>
                    </tr>
                        
                    <?php }?>
                </form>
            </tbody>
        </table>
        <input type = "button" onclick="toWelcome()" value = "Return" class="returnBtn">
        
        
        <script type="text/javascript" src="js/script.js"></script>
    </body>
<htlm>