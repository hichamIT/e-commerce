<?php require_once("../resources/config.php"); ?>
<?php require_once("cart.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<!-- /.row --> 

<div class="row">

<h1 class="text-center">THANK YOU</h1>
<?php 

if (isset($_GET['tx'])) {

    $amount = $_GET['amt'];
    $currency = $_GET['cc'];
    $transaction = $_GET['tx'];
    $status = $_GET['st'];

    $query = "insert into oredrs (order_amount, order_transction, order_status, oreder_currency) values ('{$amount}', '{$currency}', '{$transaction}', '{$status}')";
    $result = send_query($query);
    confirm($result);

}else {
    redirect('index.php');
}

?>

 </div><!--Main Content-->
 <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>
