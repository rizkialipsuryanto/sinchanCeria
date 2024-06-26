<!DOCTYPE html>
<html>

<head>
    <title>Shopping cart</title>
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/bootstrap.css' ?>"> -->

    <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?= base_url('assets/'); ?>images/favicon.png" />

    <link href="<?= base_url('vendor/bootstrap-datepicker/css/'); ?>bootstrap-datepicker3.css" rel="stylesheet">
</head>

<body>
    <div class="container"><br />
        <h2>Shopping Cart</h2>
        <hr />
        <div class="row">
            <div class="col-md-8">
                <h4>Product</h4>
                <div class="row">
                    <?php foreach ($data->result() as $row) : ?>
                        <div class="col-md-4">
                            <div class="thumbnail">
                                <img width="200" src="<?php echo base_url() . 'assets/images/' . $row->product_image; ?>">
                                <div class="caption">
                                    <h4><?php echo $row->product_name; ?></h4>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <h4><?php echo number_format($row->product_price); ?></h4>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" name="quantity" id="<?php echo $row->product_id; ?>" value="1" class="quantity form-control">
                                        </div>
                                    </div>
                                    <button class="add_cart btn btn-success btn-block" data-productid="<?php echo $row->product_id; ?>" data-productname="<?php echo $row->product_name; ?>" data-productprice="<?php echo $row->product_price; ?>">Add To Cart</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

            </div>
            <div class="col-md-4">
                <h4>Shopping Cart</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Items</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="detail_cart">

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- <script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery-3.2.1.js' ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/bootstrap.js' ?>"></script> -->

    <!-- plugins:js -->
    <script src="<?= base_url('assets/'); ?>vendors/js/vendor.bundle.base.js"></script>
    <script src="<?= base_url('assets/'); ?>vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="<?= base_url('assets/'); ?>js/off-canvas.js"></script>
    <script src="<?= base_url('assets/'); ?>js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="<?= base_url('assets/'); ?>js/dashboard.js"></script>
    <!-- End custom js for this page-->


    <script src="<?= base_url('vendor/bootstrap-datepicker/js/'); ?>bootstrap-datepicker.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.add_cart').click(function() {
                var product_id = $(this).data("productid");
                var product_name = $(this).data("productname");
                var product_price = $(this).data("productprice");
                var quantity = $('#' + product_id).val();
                $.ajax({
                    url: "<?php echo site_url('product/add_to_cart'); ?>",
                    method: "POST",
                    data: {
                        product_id: product_id,
                        product_name: product_name,
                        product_price: product_price,
                        quantity: quantity
                    },
                    success: function(data) {
                        $('#detail_cart').html(data);
                    }
                });
            });


            $('#detail_cart').load("<?php echo site_url('product/load_cart'); ?>");


            $(document).on('click', '.romove_cart', function() {
                var row_id = $(this).attr("id");
                $.ajax({
                    url: "<?php echo site_url('product/delete_cart'); ?>",
                    method: "POST",
                    data: {
                        row_id: row_id
                    },
                    success: function(data) {
                        $('#detail_cart').html(data);
                    }
                });
            });
        });
    </script>
</body>

</html>