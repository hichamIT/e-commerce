<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

    
       <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Shop Products</h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">

        <?php get_product_shop_page(); ?>

        </div>
        <!-- /.row -->

      <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>