<?php
require_once 'CarModel.php';

session_start();

//i am requiring the CarModel class and creating a new instance of it

$carModel = new CarModel();
$carId = $_GET['id'] ?? null;
$car = $carId ? $carModel->findCarById($carId) : null;

if (!$car) {
    header('Location: index.php');
    exit();
}

//after i am checking if the car exists and if not i am redirecting to the index page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Car Details</title>
</head>
<body>
    <header>
        <h1>Car Details</h1>
        <nav>
            <?php if (isset($_SESSION['user_email'])): ?>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_full_name']); ?></span>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                    <a href="adminProfile.php" class="button">Admin Profile</a>
                <?php else: ?>
                    <a href="profile.php" class="button">Profile</a>
                <?php endif; ?>
                <a href="logout.php" class="button">Logout</a>
            <?php else: ?>
                <a href="login.php" class="button">Login</a>
                <a href="register.php" class="button">Register</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <div class="car-details">
            <img src="<?php echo htmlspecialchars($car->getImage()); ?>" alt="<?php echo htmlspecialchars($car->getModel()); ?>">
            <div class="car-info">
                <h3><?php echo htmlspecialchars($car->getModel()); ?></h3>
                <p>Brand: <?php echo htmlspecialchars($car->getBrand()); ?></p>
                <p>Year: <?php echo htmlspecialchars($car->getYear()); ?></p>
                <p>Transmission: <?php echo htmlspecialchars($car->getTransmission()); ?></p>
                <p>Fuel Type: <?php echo htmlspecialchars($car->getFuelType()); ?></p>
                <p>Passengers: <?php echo htmlspecialchars($car->getPassengers()); ?></p>
                <p>Price: <?php echo htmlspecialchars($car->getDailyPriceHuf()); ?> HUF/day</p>
            </div>
        </div>
        <?php if (isset($_SESSION['user_email'])): ?>
            <div class="booking-form">
                <h3>Book this Car</h3>
                <form method="POST" action="bookCar.php">
                    <input type="hidden" name="car_id" value="<?php echo $car->getId(); ?>">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" required>
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" required>
                    <button type="submit" class="book">Book</button>
                </form>
            </div>
        <?php else: ?>
            <p>Please <a href="login.php">log in</a> to book this car.</p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> iKarRental. All rights reserved.</p>
    </footer>
</body>
</html>