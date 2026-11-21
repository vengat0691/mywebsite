<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>

<body>

<h1>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</h1>

<p>You are successfully logged in.</p>

<p>
    Email:
    <?php echo htmlspecialchars($_SESSION["user_email"]); ?>
</p>

<a href="../auth/logout.php">Logout</a>

</body>
</html>