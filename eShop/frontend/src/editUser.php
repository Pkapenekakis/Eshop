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
    if($_SESSION['role'] != 'ADMIN'){
        header('location: /WebProject/noAccess.php');    
    }

    $uid = $_SESSION['userID'];

    $query = "SELECT * FROM users WHERE ID= :uid";
    $stmt = $conn->prepare($query);
    $stmt->bindParam('uid',$uid,PDO::PARAM_STR);
    if($stmt->execute()){
        $result = $stmt->fetch();
    }

    $name = $_POST['name'] ?? $result['NAME'];
    $sName = $_POST['sname'] ?? $result['SURNAME'];
    $uName = $_POST['uname'] ?? $result['USERNAME'];
    $email = $_POST['email'] ?? $result['EMAIL'];
    $role = $_POST['role'] ?? $result['ROLE'];
    $conf = $_POST['conf'] ?? $result['CONFIRMED'];
    

    if(isset($_POST['edit'])) {

        if($result['NAME'] != $_POST['name']){
            $query = "UPDATE users SET NAME= :name WHERE ID= :uid";
            $stmt = $conn->prepare($query);
            $stmt->bindParam('uid',$uid,PDO::PARAM_STR);
            $temp = $_POST['name'];
            $stmt->bindParam('name',$temp,PDO::PARAM_STR);
            try{
                $stmt->execute();
            }catch(PDOException $e){
                echo("Error " . e->getCode() );
            }
        }
        
        if($_POST['sName'] != $result['SURNAME']){
            $query = "UPDATE users SET SURNAME= :sname WHERE ID= :uid";
            $stmt = $conn->prepare($query);
            $stmt->bindParam('uid',$uid,PDO::PARAM_STR);
            $temp = $_POST['sName'];
            $stmt->bindParam('sname',$temp,PDO::PARAM_STR);
            try{
                $stmt->execute();
            }catch(PDOException $e){
                echo("Error " . e->getCode() );
            }
        }
        if($_POST['uName'] != $result['USERNAME']){
            $query = "UPDATE users SET USERNAME= :uname WHERE ID= :uid";
            $stmt = $conn->prepare($query);
            $stmt->bindParam('uid',$uid,PDO::PARAM_STR);
            $temp = $_POST['uName'];
            $stmt->bindParam('uname',$temp,PDO::PARAM_STR);
            try{
                $stmt->execute();
            }catch(PDOException $e){
                echo("Error " . e->getCode() );
            }
        }
        if($_POST['email'] != $result['EMAIL']){
            $query = "UPDATE users SET EMAIL= :email WHERE ID= :uid";
            $stmt = $conn->prepare($query);
            $stmt->bindParam('uid',$uid,PDO::PARAM_STR);
            $temp = $_POST['email'];
            $stmt->bindParam('email',$temp,PDO::PARAM_STR);
            try{
                $stmt->execute();
            }catch(PDOException $e){
                echo("Error " . e->getCode() );
            }
        }
        if($_POST['role'] != $result['ROLE']){
            $query = "UPDATE users SET ROLE= :role WHERE ID= :uid";
            $stmt = $conn->prepare($query);
            $stmt->bindParam('uid',$uid,PDO::PARAM_STR);
            $temp = $_POST['role'];
            $stmt->bindParam('role',$temp,PDO::PARAM_STR);
            try{
                $stmt->execute();
            }catch(PDOException $e){
                echo("Error " . e->getCode() );
            }
        }
        if($_POST['conf'] != $result['CONFIRMED']){
            $query = "UPDATE users SET CONFIRMED= :conf WHERE ID= :uid";
            $stmt = $conn->prepare($query);
            $stmt->bindParam('uid',$uid,PDO::PARAM_STR);
            $temp = $_POST['conf'];
            $stmt->bindParam('conf',$temp,PDO::PARAM_STR);
            try{
                $stmt->execute();
            }catch(PDOException $e){
                echo("Error " . e->getCode() );
            }
        }
         
        header('location: /WebProject/administration.php');
    }

?>

<!DOCTYPE html>
<htlm lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title> This is a site </title>   
        <link rel="stylesheet" href="editUserStyle.css"/>    
    </head>
    
    <body> 
            
        <div class="user-card"> 
            <div class="user-card-form">
                <form method="POST" action = "#" >
                    <div class="form-input">
                        <h2>Edit User</h2>      
                        <span>Name</span>
                        <input type="text" name="name" value="<?=$name?>"/>
                    </div>

                    <div class="form-input">
                        <span>Surname</span>
                        <input type="text" name="sName" value="<?=$sName?>"/>
                    </div>

                    <div class="form-input">
                        <span>Username</span>
                        <input type="text" name="uName" value="<?=$uName?>"/>
                    </div>


                    <div class="form-input">
                        <span>Email</span>
                        <input type="text" name="email" value="<?=$email?>"/>
                    </div>

                    <div class="form-input">
                        <span>Role</span>
                        <input type="text" name="role" value="<?=$role?>"/>
                    </div>

                    <div class="form-input">
                        <span>Confirmed</span>
                        <input type="text" name="conf" value="<?=$conf?>"/>
                    </div>

                    <input type="submit" name="edit" value ="Save Changes" class="editBtn"/>


                <div class="form-other">
                    <input type = "button" onclick="toAdmin()" value = "Cancel" class="cancelButton">                          
                </div>
            </form>
            </div>    
        </div>
        
        
        <script type="text/javascript" src="js/script.js"></script>
    </body>
<htlm>