<?php
require_once "../config/database.php";

$message = "";

$host = "localhost";
$user = "root";
$password = "";
$database = "mywebsite_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $user_password = $_POST["password"];

    if (empty($name) || empty($email) || empty($user_password)) {

        $message = "Please fill in all fields.";

    } else {

        $password_hash = password_hash($user_password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password)
                VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password_hash);

        if ($stmt->execute()) {
            $message = "Registration successful!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>

<body>

<h2>Create Account</h2>

<?php if ($message != ""): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="POST" action="">

    <label>Name:</label><br>
    <input type="text" name="name" required>

    <br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required>

    <br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required>

    <br><br>

    <button type="submit">Register</button>

</form>

</body>
</html>