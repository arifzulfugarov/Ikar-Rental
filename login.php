<?php
require_once 'UserModel.php';



session_start();
$userModel = new UserModel();
$message = '';

//basically what i am doing is checking if the user is an admin or not and if not then redirecting them to the login page

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email && $password) {
        $user = $userModel->findUserByEmail($email);
        if ($user && $user->verifyPassword($password)) {
            $_SESSION['user_email'] = $user->getEmail();
            $_SESSION['user_full_name'] = $user->getFullName();
            $_SESSION['is_admin'] = $user->isAdmin();
            header('Location: index.php');   
            exit();
        } else {
            $message = 'Incorrect email or password.';
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
    <title>Login</title>
</head>
<body>
    <header>
        <h1>Login</h1>
        <nav>
            <a href="login.php" class="button">Login</a>
            <a href="register.php" class="button">Register</a>
        </nav>
    </header>
    <main>
        <form method="POST" action="login.php" novalidate>
            <label for="email">Email Address:</label>
            <input type="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
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