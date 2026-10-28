<?php
require "config/db.php";
session_start();

$error = "";
$timeout_message = "";

// Show timeout message if redirected from auth.php
if (isset($_GET['timeout'])) {
    $timeout_message = "Your session has expired due to inactivity. Please login again.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email=?");
    $stmt->execute([$_POST['email']]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($_POST['password'], $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['full_name'];

        // Reset activity timer on login
        $_SESSION['LAST_ACTIVITY'] = time();

        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login | Beauty Parlor</title>

<style>
body {
    background: linear-gradient(135deg, #fff0f5, #fdecef);
    font-family: 'Poppins', sans-serif;
    display: flex;
    height: 100vh;
    align-items: center;
    justify-content: center;
}
.card {
    background: white;
    padding: 35px;
    width: 380px;
    border-radius: 18px;
    box-shadow: 0 20px 40px rgba(0,0,0,.1);
}
h2 {
    text-align: center;
    color: #c96c86;
}
input, button {
    width: 100%;
    padding: 14px;
    margin-top: 15px;
    border-radius: 14px;
    border: 1px solid #ddd;
}
button {
    background: linear-gradient(135deg, #c96c86, #e08ca4);
    border: none;
    color: white;
    font-weight: bold;
    cursor: pointer;
}
button:hover {
    opacity: 0.9;
}
.error {
    color: red;
    text-align: center;
    margin-top: 10px;
}
.timeout {
    background: #ffe5ec;
    color: #c96c86;
    padding: 10px;
    border-radius: 12px;
    text-align: center;
    margin-bottom: 15px;
    font-size: 14px;
}
</style>
</head>

<body>
<div class="card">
    <h2>Admin Login</h2>

    <!-- Timeout Message -->
    <?php if ($timeout_message): ?>
        <div class="timeout"><?= $timeout_message ?></div>
    <?php endif; ?>

    <!-- Error Message -->
    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Admin Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Login</button>
    </form>
</div>
</body>
</html>
