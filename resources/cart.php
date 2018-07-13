<?php require_once("config.php"); ?>

<?php 

if (isset($_GET['add'])) {
    
    $query = select_one('products',$_GET['add'],'product_id');
    $result = send_query($query);
    confirm($result);

    while ($row = fetch_result($result)) {
       
        if ($row['product_quantity'] != $_SESSION['product_'.$_GET['add']]) {
            $_SESSION['product_'.$_GET['add']] +=1;
            redirect('../public/checkout.php');
        } else {
            set_message('we only heve '.$row['product_quantity']." products available");
            redirect('../public/checkout.php');
        }
        
    }
}


if (isset($_GET['remove'])) {

    $_SESSION['product_'.$_GET['remove']]--;
    if($_SESSION['product_'.$_GET['remove']] < 1){
        unset($_SESSION['item_total']);
        unset($_SESSION['item']);
        redirect('../public/checkout.php');
    }else {
        redirect('../public/checkout.php');
    }
    
}


if (isset($_GET['delete'])) {

    $_SESSION['product_'.$_GET['delete']] = '0';
        unset($_SESSION['item_total']);
        unset($_SESSION['item']);
        redirect('../public/checkout.php');    
}

function cart(){
    $total=0;
    $item =0;
    $item_name = 1;
    $item_number = 1;
    $amount = 1;
    $quantity = 1;
    foreach ($_SESSION as $name => $value) {
        
        if ($value > 0) {
            
            if (substr($name,0,8) == 'product_') {
                
                $length = strlen($name-8);
                $id = substr($name , 8 , $length);

                $query = select_one('products',$id,'product_id');
                    $result= send_query($query);
                    confirm($result);
                    while ($row = fetch_result($result)) {
                        $sub = $row['product_price']*$value;
                        $item += $value; 
                        $product =<<<DELIMETER
                        <tr>
                                <td>{$row['product_title']}</td>
                                <td>&#36;{$row['product_price']}</td>
                                <td>{$value}</td>
                                <td>&#36;{$sub}</td>
                                <td>
                                <a href='../resources/cart.php?add={$row['product_id']}' class='btn btn-success'><span class='glyphicon glyphicon-plus'></span></a>
                                <a href='../resources/cart.php?remove={$row['product_id']}' class='btn btn-warning'><span class='glyphicon glyphicon-minus'></span></a>
                                <a href='../resources/cart.php?delete={$row['product_id']}' class='btn btn-danger'><span class='glyphicon glyphicon-remove'></a></td>   
                        </tr>
                        <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
                        <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
                        <input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
                        <input type="hidden" name="quantity_{$quantity}" value="{$value}">
DELIMETER;
                echo $product;
                $item_name++;
                $item_number++;
                $amount++;
                $quantity++;
                
            }
            $total += $sub;
            $_SESSION['item_total'] = $total;
            $_SESSION['item'] = $item;

            }
        }

    }

}


function show_button(){
    if (isset($_SESSION['item']) && $_SESSION['item'] >=1 ) {
       $button =<<<DELIMETER
        <input type="image" name="upload"
        src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
        alt="PayPal - The safer, easier way to pay online">              
DELIMETER;
                return $button;
    }
}