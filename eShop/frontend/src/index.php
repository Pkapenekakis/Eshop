<?php
    define('__ROOT__', dirname(dirname(__FILE__)));
    require_once(__ROOT__.'/WebProject/database.php');
    
    //determine if we are given a username
    //if no username is given assume we pressed the login button by mistake and do nothing
    if(!empty($_POST['username'])){
        $uname=$_POST['username'];
        $password=$_POST['password'];
        
        $query = "SELECT * FROM users where USERNAME= :username and PASSWORD= :password limit :limit "; //the querry
        $stmt = $conn->prepare($query);
        $stmt->bindParam('username',$uname,PDO::PARAM_STR);
        $stmt->bindParam('password',$password,PDO::PARAM_STR);
        $limit = 1;
        $stmt->bindParam('limit',$limit,PDO::PARAM_INT);
      
        //if we got a row the user data was correct so we returned one row, assumes unique users (different credentials per user)
        if($stmt->execute()){ //if the statement succeeds it returns true
            $result = $stmt->fetch(); //get the mysqli result
            if($stmt->rowCount() == 1){
                if($result['CONFIRMED'] == 1){
                    session_start();
                    $_SESSION['id']=session_id();
                    //Since each user has unique id could not store the vars below and just get them when necessary
                    $_SESSION['userid'] = $result['ID'];
                    $_SESSION['name'] = $result['NAME'];
                    $_SESSION['surname'] = $result['SURNAME'];
                    $_SESSION['username'] = $result['USERNAME'];
                    $_SESSION['password'] = $result['PASSWORD'];
                    $_SESSION['email'] = $result['EMAIL'];
                    $_SESSION['role'] = $result['ROLE'];

                    //redirects to welcome.php and exits
                    header('Location: /WebProject/welcome.php'); 
                    exit();
                }else{
                    echo "You are not accepted into the system";
                }
                 
            }else{ //TODO possible create a warning on the page saying invalid credentials, while allowing to enter credentials again without need to hit the back button
                echo "Invalid credentials";  
                exit();
            }        
        }
        
    }else{
       
    } 

    //The below code is with mysql, PDO was better used for better reusability and security reasons
    /*$conn = new mysqli($host,$user,$password,$db);

    if($conn->connect_error){
        die("Connection failed, " . conn->connect_error);
    }

   
    //determine if we are given a username
    //if no username is given assume we pressed the login button by mistake and do nothing
    if(!empty($_POST['username'])){
        $uname=$_POST['username'];
        $password=$_POST['password'];
        
        $query = "SELECT * FROM users  where USERNAME='".$uname."' and PASSWORD='".$password."' and CONFIRMED=1 limit 1 "; //The query to select the user
        $result = mysqli_query($conn,$query);
        
        
        //if we got a row the user data was correct so we returned one row, assumes unique users (different credentials per user)
        if(mysqli_num_rows($result) == 1){
            header('Location: /WebProject/welcome.php'); //redirects to welcome.php
            exit();
        }else{ //TODO possible create a warning on the page saying invalid credentials, while allowing to enter credentials again without need to hit the back button
            echo "Invalid credentials";
            exit();
        }
        
    }else{
        
    } */
?>

<!DOCTYPE html>
<htlm lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title> This is a site </title>   
        <link rel="stylesheet" href="style.css"/>    
    </head>
    
    <body>
            <div class="login-card">
                <div class="login-card-form">
                    <form method="POST" 	>
                        <h2>Sign in</h2>
                        <div class="form-input">
                            <input type="text" name="username" required/>
                            <span>Username</span>
                            <i></i>
                        </div>      
                        <div class="form-input">
                            <input type="password" name="password" required/>
                            <span>Password</span>
                            <i></i>
                        </div>
                        <div class="form-other">
                            <div class="checkbox">
                                <input type="checkbox" id="rememberMeCheckbox">
                                <label for="rememberMeCheckbox">Remember me</label>
                            </div>
                            <a href="#">I forgot my password!</a>
                        </div> 
                        <input type="submit" name="Submit" value = "login" class="btn-login"/>
                        <input type = "button" onclick="regFunc()" value = "Register" id="RegButton" class="RegiButton">
                    </form>                  
                </div>                
            </div>         
        
        <script type="text/javascript" src="js/script.js"></script>
    </body>
<htlm>
