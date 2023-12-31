<?php require "../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->
<?php require "../includes/sidebar.php"; ?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = $connection->prepare("SELECT 
    inv.product_name,
    cat.category_name,
    inv.price,
    inv.image,
    tp.id AS transaction_product_id,
    tp.tran_id,
    tp.tr_id AS tr_id,
    tp.product_id,
    tp.quantity,
    tp.o_quantity,
    tr.total_amount,
    tr.cash_amount,
    tr.emp_id AS employee_id,
    tr.tr_date,
    tr.customer_id,
    usr.name AS employee_name
FROM 
    transaction_records tr
JOIN 
    transaction_products tp ON tr.id = tp.tran_id
JOIN 
    inventory inv ON tp.product_id = inv.id
JOIN 
    category cat ON inv.category_id = cat.id
JOIN 
    users usr ON tr.emp_id = usr.id
WHERE 
    tr.id = :id");

    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $transaction_details = $query->fetchAll(PDO::FETCH_OBJ);


}


?>

<body>
    <div class="page-wrapper">
        <div class="content">

            

            <div class="page-header">
                <div class="page-title">
                    <h4>Transaction Details</h4>
                    <h6>Full details of the customers transaction</h6>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-path">
                                <a class="btn btn-filter" id="filter_search">
                                    <img src="<?php echo FILEPATH; ?>/assets/img/icons/filter.svg" alt="img">
                                    <span><img src="<?php echo FILEPATH; ?>/assets/img/icons/closes.svg" alt="img"></span>
                                </a>
                            </div>
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="<?php echo FILEPATH; ?>/assets/img/icons/search-white.svg" alt="img"></a>
                            </div>
                        </div>
                    </div>
                    <!--Filtering option-->
                    <div class="card mb-0" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">

                            </div>
                        </div>
                    </div>
                    <!--Table data of the products-->
                    <div class="table-responsive">
                        <table class="table  datanew">
                            <thead>
                                <tr>
                                    <th>Transaction id</th>
                                    <th>Employee id</th>
                                    <th>Employee name</th>
                                    <th>Transaction Date</th>
                                    <th>Customer id</th>
                                    <th>Product id </th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Storage Quantity</th>
                                    <th>Price</th>
                                    <th>Order Quantity</th>
                                    <th>Sub Total</th>
                                    
                                    <th>Total</th>
                                    <th>Cash Tendered</th>
                                    <th>Cash exchange</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transaction_details as $transaction_info) : ?>
                                    <tr>
                                     
                                        <td><?php echo $transaction_info->tran_id; ?></td>
                                        <td><?php echo $transaction_info->employee_id; ?></td>
                                        <td><?php echo $transaction_info->employee_name; ?></td>
                                        <td><?php echo $transaction_info->tr_date; ?></td>
                                        <td><?php echo $transaction_info->customer_id; ?></td>
                                        <td><?php echo $transaction_info->product_id; ?></td>
                                        <td><?php echo $transaction_info->product_name; ?></td>
                                        <td><?php echo $transaction_info->category_name; ?></td>
                                        <td><?php echo $transaction_info->quantity; ?></td>
                                        <td><?php echo $transaction_info->price; ?></td>
                                        <td><?php echo $transaction_info->o_quantity; ?></td>
                                        <td><?php echo $subtotal = $transaction_info->price * $transaction_info->o_quantity;?></td>                                     
                                        <td><?php echo $transaction_info->total_amount; ?></td>
                                        <td><?php echo $transaction_info->cash_amount; ?></td>
                                        <td><?php echo $transaction_info->cash_amount - $transaction_info->total_amount; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <?php foreach ($transaction_details as $transaction_info) : ?>
                
           
                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="bar-code-view">
                                    <p>Bar code Not available</p>
                                    <a class="printimg">
                                        <img src="<?php echo FILEPATH; ?>/assets/img/icons/printer.svg" alt="print">
                                    </a>
                                </div>
                                <div class="productdetails">
                                    <ul class="product-bar">
                                        <li>
                                            <h4>Product</h4>
                                            <h6><?php echo $transaction_info->product_name; ?> </h6>
                                        </li>
                                        <li>
                                            <h4>Category</h4>
                                            <h6><?php echo $transaction_info->category_name;
                                                ?></h6>
                                        </li>


                                        <li>
                                            <h4>Order Quantity</h4>
                                            <h6><?php echo $transaction_info->o_quantity;
                                                ?></h6>
                                        </li>

                                        <li>
                                            <h4>Storage Quantity</h4>
                                            <h6><?php echo $transaction_info->quantity;
                                                ?></h6>
                                        </li>

                                        <li>
                                            <h4>Price</h4>
                                            <h6><?php echo $transaction_info->price;
                                                ?></h6>
                                        </li>

                                        <li>
                                            <h4>Total amount</h4>
                                            <h6><?php echo $transaction_info->total_amount;
                                                ?></h6>
                                        </li>

                                        <li>
                                            <h4>Cash tendered

                                            </h4>
                                            <h6><?php echo $transaction_info->cash_amount;
                                                ?></h6>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="slider-product-details">
                <div class="owl-carousel owl-theme product-slide">
                    <div class="slider-product" style="text-align: center;"> <!-- Centering the content -->
                        <img data-bs-target="#editProductModal" src="<?php echo FILEPATH; ?>/assets/img/product/<?php echo $transaction_info->image; ?>" alt="img" style="width: 200px; height: 300px; display: inline-block;"> <!-- Centering the image -->
                        <h4><?php echo $transaction_info->product_name; ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>

    <!-- CODE FOR THE POP-UP EDIT FORM -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product Description</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing product -->
                    <form action="../process/product_crud/update_description.php" method="POST">

                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label">Product Description</label>
                            <input type="hidden" id="id" name="id">
                            <textarea id="description" name="description" class="form-control" rows="4" cols="50">
                            </textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="update_description" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require "../includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>
<script>
    // php to html
    function Edit_Category(description, id) {
        $('#id').val(id);
        $('#description').val(description);
    }
</script>

</html>