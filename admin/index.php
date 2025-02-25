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
    <title>Login Form</title>
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
        require_once "config.php";
        $email = "";
        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
            $email = htmlspecialchars(trim($_POST['email']));
            $password = $_POST['password'];

            if (empty($email) || empty($password)) {
                array_push($errors, "All fields are required.");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Invalid email format.");
            }

            if (count($errors) == 0) {
                $stmt = $conn->prepare("SELECT id, password FROM admin WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($user_id, $hashed_password);
                    $stmt->fetch();
                    if (password_verify($password, $hashed_password)) {
                        echo "<div class='alert alert-success'>Login successful! Welcome.</div>";
                        session_start();
                        $_SESSION["admin_id"] = $user_id;
                        $_SESSION["email"] = $email;
                        header("Location:admin.php");
                        exit();
                    } else {
                        array_push($errors, "Incorrect password.");
                    }
                } else {
                    array_push($errors, "Email not found.");
                }

                $stmt->close();
            }

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }
        }

        $conn->close();
        ?>
        <form action="" method="post">
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" class="btn btn-primary" name="login">
            </div>
        </form>
        <div>
            <div><p>Not Registered yet<a href="registration.php"> Register Here</a></p></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>

</html>