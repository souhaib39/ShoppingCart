<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php include 'config.php'; ?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <?php include 'header.php'; ?>



    <section class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="add-products" style="margin-top: 5px;">
                    <h4 class="text-center text-info m-0">
                        Add Products
                    </h4>
                </div>
                <form action="action.php" method="post" class="border p-4 rounded custom-gray-bg" enctype="multipart/form-data">
                    <div class="form-group">
                        <label><b>Phone Models</b></label>
                        <select name="p_models" class="form-control" required>
                            <option value="">Choose...</option>
                            <option value="Samsung">Samsung</option>
                            <option value="Apple">Apple</option>
                            <option value="Oppo">Oppo</option>
                            <option value="Huawei">Huawei</option>
                            <option value="Xiaomi">Xiaomi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><b>Phone Name</b></label>
                        <input type="text" class="form-control" placeholder="phone name" name="p_name" required>
                    </div>
                    <div class="form-group">
                        <label><b>Phone Image</b></label>
                        <input type="file" class="form-control" name="p_image" accept="image/png, image/jpg, image/jpeg, image/webp" required>
                    </div>
                    <div class="form-group">
                        <label><b>Phone Price</b></label>
                        <input type="text" class="form-control" placeholder="phone price" name="p_price" required>
                    </div>
                    <div class="form-group">
                        <label><b>Phone Code</b></label>
                        <input type="text" class="form-control" placeholder="phone code" name="p_code" required>
                    </div>
                    <button type="submit" class="btn btn-custom-green btn-block" name="add_product">Add The Product</button>
                </form>
            </div>
        </div>
    </section>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 mx-auto px-3">
                <div class="table-responsive mt-2">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <td colspan="7">
                                    <h4 class="text-center text-info m-0">
                                        Manage Products by Phone Model
                                    </h4>
                                </td>
                            </tr>
                            <tr>
                                <th>ID Phone</th>
                                <th>Name Phone</th>
                                <th>Image Phone</th>
                                <th>Price Phone</th>
                                <th>Code Phone</th>
                                <th>Models Phone</th>
                                <th>
                                    <a href="action.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Are you sure you want to clear your cart?');"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require 'config.php';
                            $stmt = $conn->prepare('SELECT * FROM  products');
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()):
                            ?>
                                <tr>
                                    <td class="id_product"><?= $row['id_product'] ?></td>
                                    <td><?= $row['product_name'] ?></td>
                                    <td><img src="../image/<?= $row['product_image'] ?>" width="50"></td>
                                    <td>
                                        <b>DA</b>&nbsp;&nbsp;<?= number_format($row['product_price'], 2); ?>
                                    </td>
                                    <td><?= $row['product_code'] ?></td>
                                    <td><?= $row['product_models'] ?></td>
                                    <td>
                                        <a href="#" class="delete-btn text-danger lead"><i class="fas fa-trash-alt"></i></a>&nbsp;&nbsp;&nbsp;
                                        <a href="#" class="edit-btn text-danger lead"><i class='far fa-edit'></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>






    <!-- Modal Structure -->
    <div class="modal fade" id="ProductEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="hidden" id="edit_id">
                            <div class="form-group">
                                <label for="edit_name">Product Name</label>
                                <input type="text" id="edit_name" class="form-control">
                            </div>

                            <!-- Product Price -->
                            <div class="form-group">
                                <label for="edit_price">Product Price</label>
                                <input type="text" id="edit_price" class="form-control">
                            </div>

                            <!-- Product Code -->
                            <div class="form-group">
                                <label for="edit_code">Product Code</label>
                                <input type="text" id="edit_code" class="form-control">
                            </div>

                            <!-- Product Models (Dropdown) -->
                            <div class="form-group">
                                <label for="edit_models">Product Models</label>
                                <select id="edit_models" class="form-control">
                                    <option value="Samsung">Samsung</option>
                                    <option value="Apple">Apple</option>
                                    <option value="Oppo">Oppo</option>
                                    <option value="Huawei">Huawei</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <img id="edit_image" src="" alt="Product Image" class="img-fluid" style="max-width: 100%; height: auto;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" id="btn-modal-close" class="btn btn-primary" data-dismiss="modal">Close</button>
                    <button type="button" id="btn-modal-save" class="btn btn-primary update_product_ajax">Save</button>
                </div>
            </div>
        </div>
    </div>






    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.addEventListener('click', function(e) {
                if (e.target.closest('.edit-btn')) {
                    e.preventDefault();
                    const row = e.target.closest('tr');
                    const id_product = row.querySelector('.id_product').textContent;

                    const formData = new FormData();
                    formData.append('checking_edit', true);
                    formData.append('id_product', id_product);

                    fetch('action.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Network error');
                            return response.json();
                        })
                        .then(data => {
                            document.getElementById('edit_id').value = data.id_product;
                            document.getElementById('edit_name').value = data.product_name;
                            document.getElementById('edit_price').value = data.product_price;
                            document.getElementById('edit_code').value = data.product_code;
                            document.getElementById('edit_models').value = data.product_models;
                            document.getElementById('edit_image').src = '../image/' + data.product_image;
                            new bootstrap.Modal(document.getElementById('ProductEditModal')).show();
                        })
                        .catch(error => console.error('Error:', error));
                }
            });


            document.addEventListener('click', function(e) {
                if (e.target.closest('.update_product_ajax')) {
                    const prod_id = document.getElementById('edit_id').value;
                    const name = document.getElementById('edit_name').value;
                    const price = document.getElementById('edit_price').value;
                    const code = document.getElementById('edit_code').value;
                    const model = document.getElementById('edit_models').value;

                    const formData = new FormData();
                    formData.append('update_product', true);
                    formData.append('product_id', prod_id);
                    formData.append('product_name', name);
                    formData.append('product_price', price);
                    formData.append('product_code', code);
                    formData.append('product_model', model);

                    fetch('action.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Network error');
                            return response.json();
                        })
                        .then(data => {
                            if (data.status === "success") {
                                alert(data.message);
                                bootstrap.Modal.getInstance(document.getElementById('ProductEditModal')).hide();
                                location.reload();
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            });



             document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-btn')) {
                    e.preventDefault();
                    if (!confirm('Are you sure you want to delete this item?')) {
                        return;
                    }

                    const row = e.target.closest('tr');
                    const id_product = row.querySelector('.id_product').textContent;

                    const formData = new FormData();
                    formData.append('checking_delete', true);
                    formData.append('id_product', id_product);

                    fetch('action.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Network error');
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                row.remove(); // Remove the row from DOM
                            } else {
                                alert('Delete failed: ' + data.message);
                            }
                        })
                        .catch(error => {
                           console.error('Error:', error);
                            alert('An error occurred while deleting');
                        });
                }
            });

        });
    </script>









    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
</body>

</html>