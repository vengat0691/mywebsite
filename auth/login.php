<?php

session_start();

require_once "../config/database.php";

$message = "";


if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $user_password = $_POST["password"];

    if (empty($email) || empty($user_password)) {

        $message = "Please enter your email and password.";

    } else {

        $sql = "SELECT id, name, email, password FROM users WHERE email = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user_data = $result->fetch_assoc();

            if (password_verify($user_password, $user_data["password"])) {

                $_SESSION["user_id"] = $user_data["id"];
                $_SESSION["user_name"] = $user_data["name"];
                $_SESSION["user_email"] = $user_data["email"];

                header("Location: ../pages/dashboard.php");
                exit;

            } else {

                $message = "Invalid email or password.";

            }

        } else {

            $message = "Invalid email or password.";

        }

        $stmt->close();
    }
}

$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>

<body>

<h2>Login</h2>

<?php if ($message != ""): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="POST" action="">

    <label>Email:</label><br>
    <input type="email" name="email" required>

    <br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required>

    <br><br>

    <button type="submit">Login</button>

</form>

<br>

<a href="register.php">Create a new account</a>

</body>
</html>