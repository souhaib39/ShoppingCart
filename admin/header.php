<header class="fixed-top" style="box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-1">
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#" id="adminDetailsButton" data-id="<?php echo $_SESSION['admin_id']; ?>">
                        <i class='far fa-address-card' style='font-size:24px'></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link  active mr-5" href="orders.php">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  active mr-5" href="#">add products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  active  mr-5" href="checkout.php"></i>view products</a>
                </li>
                <?php
                $select_rows = mysqli_query($conn, "SELECT * FROM products") or die('query failed');
                $row_count = mysqli_num_rows($select_rows);
                ?>

                <li class="nav-item">
                    <a class="nav-link active">
                        Total Products
                        <span id="cart-item" class="badge badge-danger"><?php echo $row_count; ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="logout.php"><i class="fa-solid fa-right-from-bracket" style='font-size:23px'></i></a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- View Modal -->
    <div class="modal fade" id="AdminViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Admin Detail View</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="fullname"></h4>
                    <h4 class="email"></h4>
                    <h4 class="password"></h4>
                </div>
                <div class="modal-footer">
                    <<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    </div>
    <script>
        $(document).ready(function() {

            document.getElementById('adminDetailsButton').addEventListener('click', function(e) {
                e.preventDefault();

                var adminId = this.getAttribute('data-id');
                console.log(adminId);
                fetch('action.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            adminId: adminId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Data received:', data.email);
                        $('.fullname').text(data.fullname);
                        $('.email').text(data.email);
                        $('#AdminViewModal').modal('show');
                    })

                    .catch(error => {
                        console.error('Error:', error);
                    });
            });


            /*
                        

                        $(document).on("click", ".edit_btn", function() {

                            var id_product = $(this).closest('tr').find('.id_product').text();
                            // console.log(id_product);

                            $.ajax({
                                type: "POST",
                                url: "action.php",
                                data: {
                                    'checking_edit': true,
                                    'id_product': id_product,
                                },
                                success: function(response) {
                                    //    console.log(response);
                                    $.each(response, function(key, prodEdit) {
                                        //  console.log(prodEdit['id_product']);
                                        $('#edit_id').val(prodEdit['id_product']);
                                        $('#edit_name').val(prodEdit['product_name']);
                                        $('#edit_price').val(prodEdit['product_price']);
                                        $('#edit_code').val(prodEdit['product_code']);
                                        $('#edit_models').val(prodEdit['product_models']);

                                        // Set the image source
                                        var baseImagePath = "../image/";
                                        var imageName = prodEdit['product_image'];
                                        var fullImagePath = baseImagePath + imageName;
                                        $('#edit_image').attr('src', fullImagePath);
                                    });
                                    $('#ProductEditModal').modal('show');

                                }
                            });

                        });
                     */

        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
</header>