<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title> This is a site </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel = "stylesheet" href="productsStyle.css">
        <script type="text/javascript" src="js/script.js"></script>
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
    </body>
<htlm>