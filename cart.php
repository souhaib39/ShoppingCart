<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="Sahil Kumar">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cart</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/styleHeader.css">
</head>
<?php include 'header.php'; ?>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div style="display:<?php if (isset($_SESSION['showAlert'])) {
                            echo $_SESSION['showAlert'];
                          } else {
                            echo 'none';
                          }
                          unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><?php if (isset($_SESSION['message'])) {
                  echo $_SESSION['message'];
                }
                unset($_SESSION['showAlert']); ?></strong>
      </div>
      <div class="table-responsive mt-2">
        <table class="table table-bordered table-striped text-center">
          <thead>
            <tr>
              <td colspan="7">
                <h4 class="text-center text-info m-0">Products in your cart!</h4>
              </td>
            </tr>
            <tr>
              <th>Image</th>
              <th>Product</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total Price</th>
              <th>
                <a href="action.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Are you sure want to clear your cart?');"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
            require 'config.php';
            $stmt = $conn->prepare('SELECT * FROM cart');
            $stmt->execute();
            $result = $stmt->get_result();
            $grand_total = 0;
            while ($row = $result->fetch_assoc()):
            ?>
              <tr>
                <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                <td><img src="image/<?= $row['product_image'] ?>" width="50"></td>
                <td><?= $row['product_name'] ?></td>
                <td>
                  <b>DA</b>&nbsp;&nbsp;<?= number_format($row['product_price'], 2); ?>
                </td>
                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                <td>
                  <input type="number" class="form-control itemQty" value="<?= $row['qty'] ?>" style="width:75px;">
                </td>
                <td><b>DA</b>&nbsp;&nbsp;<?= number_format($row['total_price'], 2); ?></td>
                <td>
                  <a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure want to remove this item?');"><i class="fas fa-trash-alt"></i></a>
                </td>
              </tr>
              <?php $grand_total += $row['total_price']; ?>
            <?php endwhile; ?>
            <tr>
              <td colspan="2">
                <a href="index.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Continue
                  Shopping</a>
              </td>
              <td colspan="2"><b>Grand Total</b></td>
              <td><b>DA&nbsp;&nbsp;<?= number_format($grand_total, 2); ?></b></td>
              <td>
                <a href="checkout.php" class="btn btn-info <?= ($grand_total > 1) ? '' : 'disabled'; ?>"><i class="far fa-credit-card"></i>&nbsp;&nbsp;Checkout</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

<script src="js/JavaScript.js"></script>
<script>
  $(document).ready(function() {
    $(".itemQty").on('change', function() {
      var $el = $(this).closest('tr');

      var pid = $el.find(".pid").val();
      var pprice = $el.find(".pprice").val();
      var qty = $el.find(".itemQty").val();
      location.reload(true);
      $.ajax({
        url: 'action.php',
        method: 'post',
        cache: false,
        data: {
          qty: qty,
          pid: pid,
          pprice: pprice
        },
        success: function(response) {
          console.log(response);
        }
      });
    });

  })
</script>
</body>

</html>