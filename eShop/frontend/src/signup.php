<?php
    define('__ROOT__', dirname(dirname(__FILE__)));
    require_once(__ROOT__.'/WebProject/database.php');

    //TODO Add checks for compatability with the database
    if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['username'])&& !empty($_POST['password'])&& !empty($_POST['repPassword'])&& !empty($_POST['email']) && !empty($_POST['role']) ){
        $name=$_POST['name'];
        $surname=$_POST['surname'];
        $uname=$_POST['username'];
        $password=$_POST['password'];
        $repPass=$_POST['repPassword'];
        $email=$_POST['email'];
        $role = $_POST['role'];
        
        if($password != $repPass){
            echo("Passwords do not match");
        }else{
             $query = "INSERT INTO users (NAME, SURNAME, USERNAME,PASSWORD,EMAIL,ROLE) VALUES (?,?,?,?,?,?)";
            try{
                $stmt = $conn->prepare($query);
                $stmt->execute([$name,$surname,$uname,$password,$email,$role]);
            }catch(PDOException $e){
                echo("Error " . e->getCode() );
            }    
        }
        
        header('Location: /WebProject/index.php');
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
        <link rel = "stylesheet" href="signupStyle.css">
        
    </head>
    
    <body>
        <div class="register-card">
            <div class="register-card-form">
                <form method = "POST" action = "#">          
                    <div class="form-input">
                        <h2>Register</h2>
                        
                        <input type="text" name="name" required/>
                        <span>Name</span>
                        <i></i>
                    </div>

                    <div class="form-input">
                        <input type="text" name="surname" required/>
                        <span>Surname</span>
                        <i></i>
                    </div>

                    <div class="form-input">
                        <input type="text" name="email" required/>
                        <span>Email</span>
                        <i></i>
                    </div>

                    <div class="form-input">
                        <input type="text" name="username" required/>
                        <span>Username</span>
                        <i></i>
                    </div>

                    <div class="form-input">
                        <input type="text" name="password" required/>
                        <span>Password</span>
                        <i></i>
                    </div>

                    <div class="form-input">
                        <input type="text" name="repPassword" required/>
                        <span>Repeat the password</span>
                        <i></i>
                    </div>

                    <div class="form-input">
                        <label for="role">Role</label>
                        <select name="role" id="role">
                            <optgroup>
                                <option value="USER">User</option>
                                <option value="PRODUCTSELLER">Seller</option>
                            </optgroup>   
                        </select>
                    </div> 
                    
                    <input type="submit" name="submit" value = "Register" class="btn-register"/>
                    <input type = "button" onclick="backToHome()" value = "Cancel" class="cancelButton">
                </form>
            </div>
            
            <script type="text/javascript" src="js/script.js"></script>
        </div>       
    </body>
<htlm>