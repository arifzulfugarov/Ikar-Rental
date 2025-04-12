<?php
require_once 'UserModel.php';

$userModel = new UserModel();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($fullName && $email && $password) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Invalid email address.';
        } elseif (strlen($password) < 6) {
            $message = 'Password must be at least 6 characters long.';
        } else {
            $existingUser = $userModel->findUserByEmail($email);
            if ($existingUser) {
                $message = 'Email is already registered.';
            } else {
                $user = new User($fullName, $email, $password);
                $userModel->addUser($user);
                $message = 'Registration successful!';
            }
        }
    } else {
        $message = 'All fields are required.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Register</title>
</head>
<body>
    <header>
        <h1>Register</h1>
        <nav>
            <a href="login.php" class="button">Login</a>
            <a href="register.php" class="button">Register</a>
        </nav>
    </header>
    <main>
        <form method="POST" action="register.php" novalidate>
            <label for="fullName">Full Name:</label>
            <input type="text" name="fullName" required>
            <label for="email">Email Address:</label>
            <input type="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Register</button>
        </form>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> iKarRental. All rights reserved.</p>
    </footer>
</body>
</html>