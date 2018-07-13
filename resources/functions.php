<?php 

//function redirect page
function redirect($location){

    header("Location: $location");
    
}

//function execute query
function select_all($table){

    return "SELECT * FROM ".$table."";
    
}

//function one element
function select_one($table,$id,$column){

    return "SELECT * FROM ".$table." WHERE " .$column ." = " .escape_string($id)."";
    
}

//function execite query
function send_query($sql){

    global $connection;
    return mysqli_query($connection,$sql);
    
}

//function confirm query
function confirm($result){

    global $connection;
    if (!$result) {
        die("QUERY FAILED". mysqli_error($connection));
    }
    
}

//function escape value 
function escape_string($string){

    global $connection;
    return mysqli_escape_string($connection,$string);
    
}

//function fetch array 
function fetch_result($result){

    global $connection;
    return mysqli_fetch_array($result);
    
}

//function Get products
function get_product(){

    global $connection;
    $query = select_all('products');
    $result = send_query($query);
    confirm($result);
    while ($row = fetch_result($result)) {
        $product = <<<DELIMETER
        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail">
                <a href="item.php?id={$row['product_id']}"><img src="{$row['product_image']}" alt=""></a>
                    <div class="caption">
                     <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                    <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
                    <p>See more snippets like this online store item at <a target="_blank" href="#">Bootsnipp - http://bootsnipp.com</a>.</p>
                    <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to cart</a>
            </div>            
            </div>
        </div>
DELIMETER;
        echo $product;
    }  
}

//function Get category
function get_category(){
    
    global $connection;
    $query = select_all("categories");
    $result = send_query($query);
    confirm($result);
    while ($row = fetch_result($result)) {
        $category = <<<DELIMETER
    <a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>
DELIMETER;
        echo $category;
    }  
}

//function Get category products
function get_product_cat_page(){

    global $connection;
    $query = select_one('products',$_GET['id'],'product_category_id');
    $result = send_query($query);
    confirm($result);
    while ($row = fetch_result($result)) {
        $product = <<<DELIMETER
        <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="{$row['product_image']}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
DELIMETER;
        echo $product;
    }  
}


//function Get shop products
function get_product_shop_page(){

    global $connection;
    $query = select_all('products');
    $result = send_query($query);
    confirm($result);
    while ($row = fetch_result($result)) {
        $product = <<<DELIMETER
        <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="{$row['product_image']}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
DELIMETER;
        echo $product;
    }  
}


function login_user(){
    global $connection;
    if (isset($_POST['submit'])) {

        $password = escape_string($_POST['password']);
        $username = escape_string($_POST['username']);

        $query = "select * from users where username = '{$username}' and password = '{$password}'";
        $result = send_query($query);
        confirm($result);

        if (mysqli_num_rows($result) == 0) {
            set_message('Your Email Or Password Are Wrong');
            redirect('login.php');
            
        } else {
            $_SESSION['username'] = $username;
            redirect('admin');
        }
        
    } 
}

function send_message(){
    
    if (isset($_POST['submit'])) {

       $to ='elkhaldihicham@gmail.com';
       $from_name = $_POST['name'] ;
       $subject = $_POST['subject'];
       $message = $_POST['message'];
       $email = $_POST['email'];
       $header = "From :{$from_name} {$email} ";

       $result = mail($to,$subject,$message);

       if (!$result) {
           set_message('Your email has been sent');
           redirect('contact.php');
       } else {
           set_message('Error !!! We could not sent your message');
           redirect('contact.php');
       }
       
    } 
}

function set_message($msg){
    if(!empty($msg)){
        $_SESSION['message'] = $msg;
    }else {
        $msg = '';
    }
}

function display_msg(){
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    } else {
        # code...
    }
    
}

