<?php
$site = "Products";

include 'includes/adminHeader.php';

if ($currentUser->role_name === 'user') {
    redirect('index.php');
};

$products = app('db')->select(
    "SELECT * FROM `products`"
);

$categories = app('db')->select(
    "SELECT DISTINCT `product_category` FROM `products`"
);

?>
<div id="layoutDrawer_content">
    <main>
        <div class="container-xl p-5 center">
            <div class="row">
                <div class="col-md-12">
                    <h4>Dashboard</h4>
                </div>
                <div>
                    <button type="button" class="btn btn-success mb-2" id="btn-show-product-modal" data-bs-target="#modal-add-edit-product" data-bs-toggle="modal">
                        <i class="bi bi-bag-plus-fill"></i> Add Product
                    </button>
                </div>
            </div>

            <?php include 'includes/_tablesProducts.php'; ?>
        </div>
    </main>
</div>
<?php
include 'includes/adminFooter.php';
