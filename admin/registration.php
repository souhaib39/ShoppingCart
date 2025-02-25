<?php
session_start();
if (isset($_SESSION["admin_id"])) {
    header("Location:admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            padding: 50px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 50px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .form-group {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        $fullname = $email = "";
        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
            $fullname = htmlspecialchars(trim($_POST['fullname']));
            $email = htmlspecialchars(trim($_POST['email']));
            $password = $_POST['password'];
            $repeat_password = $_POST['repeat_password'];

            if (empty($fullname) || empty($email) || empty($password) || empty($repeat_password)) {
                array_push($errors, "All fields are required.");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid.");
            }
            if (strlen($password) < 8) {
                array_push($errors, "Password must be at least 8 characters long.");
            }
            if ($password !== $repeat_password) {
                array_push($errors, "Passwords do not match.");
            }

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            } else {
                require_once "config.php";
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO admin (fullname, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $fullname, $email, $hashed_password);

                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Registration successful!</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
                }

                $stmt->close();
            }
        }
        ?>
        <form action="" method="post">
            <div class="form-group">
                <input type="text" name="fullname" class="form-control" placeholder="Full Name" value="<?php echo $fullname; ?>">
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" name="repeat_password" class="form-control" placeholder="Repeat Password">
            </div>
            <div class="form-btn">
                <input type="submit" value="Register" class="btn btn-primary" name="submit">
            </div>
        </form>
        <div>
            <div><p>Already Registered<a href="index.php"> Login Here</a></p></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>

</html>