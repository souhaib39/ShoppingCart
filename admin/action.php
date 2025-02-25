<?php
session_start();
//include 'config.php';
$conn = mysqli_connect("localhost", "root", "", "cart_system") or die('connection failed');

if (isset($_POST['add_product'])) {
    $p_models = mysqli_real_escape_string($conn, $_POST['p_models']);
    $p_name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $p_price = mysqli_real_escape_string($conn, $_POST['p_price']);
    $p_code = mysqli_real_escape_string($conn, $_POST['p_code']);

    $p_image = $_FILES['p_image']['name'];
    $p_image_tmp = $_FILES['p_image']['tmp_name'];
    $upload_dir = '../image/' . $p_image;

    $allowed_ext = ['png', 'jpg', 'jpeg', 'webp'];
    $file_ext = strtolower(pathinfo($p_image, PATHINFO_EXTENSION));
    if (in_array($file_ext, $allowed_ext)) {

        $stmt = $conn->prepare("INSERT INTO products (product_name,product_price,product_image,product_code,product_models) VALUES (?, ?, ?, ?,?)");
        $stmt->bind_param("sssss", $p_name, $p_price, $p_image, $p_code, $p_models);

        if ($stmt->execute()) {
            move_uploaded_file($p_image_tmp, $upload_dir);
            $message[] = 'Product added successfully!';
            header('location:index.php');
        } else {
            $message[] = 'Error adding product ' . $stmt->error;
            header('location:index.php');
        }
    } else {
        $message[] = 'File extension not allowed (PNG, JPG, JPEG ,WEBP only)';
        header('location:index.php');
    }
}


if (isset($_POST['checking_edit'])) {
    header('Content-Type: application/json');

    $id_product = $_POST['id_product'];
    $response = [];


    $stmt = $conn->prepare("SELECT * FROM products WHERE id_product = ?");
    $stmt->bind_param("i", $id_product);

    try {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response = $result->fetch_assoc();
        } else {
            $response['error'] = "No Record Found!";
        }
    } catch (mysqli_sql_exception $e) {
        $response['error'] = "Database error: " . $e->getMessage();
    }

    echo json_encode($response);
    exit();
}



if (isset($_POST['update_product'])) {
    header('Content-Type: application/json');

    try {
        $required_fields = ['product_id', 'product_name', 'product_price', 'product_code', 'product_model'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Enter the $field field");
            }
        }

        $prod_id = (int)$_POST['product_id'];
        $prod_name = htmlspecialchars($_POST['product_name']);
        $prod_price = (float)$_POST['product_price'];
        $prod_code = htmlspecialchars($_POST['product_code']);
        $prod_model = htmlspecialchars($_POST['product_model']);

        $stmt = $conn->prepare("UPDATE products SET product_name = ?, product_price = ?, product_code = ?, product_models = ? WHERE id_product = ?");
        $stmt->bind_param("sdssi", $prod_name, $prod_price, $prod_code, $prod_model, $prod_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => 'The product has been updated successfully',
                'affected_rows' => $stmt->affected_rows
            ]);
        } else {
            echo json_encode([
                'status' => 'warning',
                'message' => 'No data has been updated (the same data may already exist)'
            ]);
        }
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage(),
            'error_code' => $e->getCode()
        ]);
    }

    exit();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $admin_id = $data['adminId'];

    $admin_id = mysqli_real_escape_string($conn, $admin_id);

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE id = '$admin_id'");
    $admin = mysqli_fetch_assoc($query);

    if ($admin) {
        header('Content-Type: application/json');
        echo json_encode($admin);
    } else {
        echo json_encode(['error' => 'Admin not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}





header('Content-Type: application/json');

if (isset($_POST['checking_delete'])) {
    $id_product = (int)$_POST['id_product'];
    
    if ($id_product <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid product number']);
        exit();
    }

    
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Connection failed' . $conn->connect_error]);
        exit();
    }
    

    $stmt = $conn->prepare("DELETE FROM products WHERE id_product = ?");
    $stmt->bind_param('i', $id_product);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Successfully deleted']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
    }
    
    $stmt->close();
    $conn->close();
    exit();
}


header('Content-Type: application/json');

if (isset($_POST['checking_order_delete'])) {
    $id_orders = (int)$_POST['id_orders'];
    
    if ($id_orders <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid product number']);
        exit();
    }

    
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Connection failed' . $conn->connect_error]);
        exit();
    }
    

    $stmt = $conn->prepare("DELETE FROM orders WHERE id_orders= ?");
    $stmt->bind_param('i', $id_orders);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Successfully deleted']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
    }
    
    $stmt->close();
    $conn->close();
    exit();
}