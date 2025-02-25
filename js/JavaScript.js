const navLinkEls = document.querySelectorAll(".nav_link");
const windowPathname = window.location.pathname;

navLinkEls.forEach(navLinkEl => {
  let navLinkPathname = navLinkEl.getAttribute("href");

  if (windowPathname.endsWith(navLinkPathname) ||
    (windowPathname === "/" && navLinkPathname === "index.html")) {
    navLinkEl.classList.add("active");
  }
});

//_____________________________________________

$(document).ready(function () {

  $(".itemQty").on('change', function () {
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
      success: function (response) {
        console.log(response);
      }
    });
  });

  // Send product details in the server
  $(".addItemBtn").click(function (e) {
    e.preventDefault();
    var $form = $(this).closest(".form-submit");
    var pid = $form.find(".pid").val();
    var pname = $form.find(".pname").val();
    var pprice = $form.find(".pprice").val();
    var pimage = $form.find(".pimage").val();
    var pcode = $form.find(".pcode").val();

    var pqty = $form.find(".pqty").val();

    $.ajax({
      url: 'action.php',
      method: 'post',
      data: {
        pid: pid,
        pname: pname,
        pprice: pprice,
        pqty: pqty,
        pimage: pimage,
        pcode: pcode
      },
      success: function (response) {
        $("#message").html(response);
        window.scrollTo(0, 0);
        load_cart_item_number();
      }
    });
  });

  //_________________________________________________________//

  load_cart_item_number();

  function load_cart_item_number() {
    $.ajax({
      url: 'action.php',
      method: 'get',
      data: {
        cartItem: "cart-item"
      },
      success: function (response) {
        $("#cart-item").html(response);
      }
    });
  }
});