<div class="row">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-table me-2"></i></span> Data Table
            </div>
            <div class="card-body">

                <div class="d-flex justify-content-center">
                    <div class="ajax-loading spinner-border text-primary m-5" role="status" id="loading-products">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped data-table" id="products-list" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Product Color</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product) : ?>
                                <tr class="product-row">
                                    <td><?= $product['product_id'] ?></td>
                                    <td><?= $product['product_name'] ?></td>
                                    <td><?= $product['product_category'] ?></td>
                                    <td>$<?= $product['product_price'] ?></td>
                                    <td><?= $product['product_color'] ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary">
                                                <i class="bi bi-bag-plus-fill"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item edit-product" data-bs-target="#modal-add-edit-product" data-bs-toggle="modal" data-item="<?= $product['product_id'] ?>">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item product-details" data-bs-target="#modal-product-details" data-bs-toggle="modal" data-item="<?= $product['product_id'] ?>">
                                                        <i class="bi bi-info-square"></i> Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item delete-product" href="javascript:;" data-item="<?= $product['product_id'] ?>">
                                                        <i class=" bi bi-trash"></i>
                                                        <span class="text-danger">Delete</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-product-details">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-md-center">
                        <div class="col-md-5 text-center">
                            <form class="add-image" method="post" enctype="multipart/form-data">
                                <img class="img-fluid mb-1" id="product-img" src="" alt="..." style="max-width: 250px; max-height: 250px" />
                                <!-- Product picture help block-->
                                <div class="caption fst-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                <!-- Product picture upload button-->
                                <input type="file" name="imgUpload[]" accept="image/*" id="productImg" multiple />
                                <button class="btn btn-primary mt-2" id="Upload">
                                    Upload 4 new images
                                    <i class="material-icons trailing-icon">upload</i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-5 text-center">
                            <dl class="dl-horizontal">
                                <dt title="name">Product Name</dt>
                                <dd id="modal-details--name"></dd>
                                <dt title="description">Product Description</dt>
                                <dd id="modal-details--description"></dd>
                                <dt title="price">Product Price</dt>
                                <dd id="modal-details--price"></dd>
                                <dt title="color">Color</dt>
                                <dd id="modal-details--color"></dd>
                                <dt title="category">Category</dt>
                                <dd id="modal-details--category"></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="ajax-loading spinner-border text-primary m-5" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary eraseInput" data-bs-dismiss="modal" href="javascript:;">Close</button>
                <button type="submit" class="btn btn-primary eraseInput" data-bs-dismiss="modal" href="javascript:void(0)">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-edit-product" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-name">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="p-2" id="add-product-form">
                <div class="modal-body" id="details-body">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input name="product_name" type="text" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label>Product Description</label>
                        <input name="product_desc" type="text" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input name="product_price" type="number" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label>Color</label>
                        <input name="product_color" type="text" class="form-control" />
                    </div>

                    <hr class="mt-4 mb-4">
                    <?php if (count($categories) > 0) : ?>
                        <label>Select Category</label>
                        <select class="form-select" aria-label="Category" name="product_category">
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category['product_category'] ?>">
                                    <?= ucfirst($category['product_category']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                    <div class="d-flex justify-content-center">
                        <div class="ajax-loading spinner-border text-primary m-5" role="status" style="display: none;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-add-product" name="button">Add</button>
                    </div>
            </form>
        </div>
    </div>
</div>