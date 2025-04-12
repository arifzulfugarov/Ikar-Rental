<?php
require_once 'CarModel.php';

session_start();

// If the user is not logged in, redirect to the login page


//i am requiring the CarModel class
$carModel = new CarModel();
$success = $_GET['success'] ?? 0;
$carId = $_GET['car_id'] ?? null;
$startDate = $_GET['start_date'] ?? null;
$endDate = $_GET['end_date'] ?? null;
$totalPrice = $_GET['total_price'] ?? null;
$error = $_GET['error'] ?? null;

$car = $carId ? $carModel->findCarById($carId) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Booking Result</title>
</head>
<body>
    <header>
        <h1>Booking Result</h1>
        <nav>
            <?php if (isset($_SESSION['user_email'])): ?>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_full_name']); ?></span>
                <a href="profile.php" class="button">Profile</a>
                <a href="logout.php" class="button">Logout</a>
            <?php else: ?>
                <a href="login.php" class="button">Login</a>
                <a href="register.php" class="button">Register</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <?php if ($success): ?>
            <div class="booking-success">
                <h2>Booking Successful!</h2>
                <img src="success.png" alt="Success">
                <?php if ($car): ?>
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
                    <div class="booking-details">
                        <h3>Booking Details</h3>
                        <p>Booking Dates: <?php echo htmlspecialchars($startDate); ?> to <?php echo htmlspecialchars($endDate); ?></p>
                        <p>Total Price: <?php echo htmlspecialchars($totalPrice); ?> HUF</p>
                    </div>
                <?php endif; ?>
                <a href="index.php" class="button return-home">Return to Homepage</a>
            </div>
        <?php else: ?>
            <div class="booking-failure">
                <h2>Booking Failed</h2>
                <img src="fail.png" alt="Failure">
                <?php if ($error == 'invalid_dates'): ?>
                    <p>The start date must be before the end date.</p>
                <?php elseif ($error == 'unavailable'): ?>
                    <p>The car is not available for the selected dates.</p>
                <?php else: ?>
                    <p>There was an error processing your request. Please try again.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> iKarRental. All rights reserved.</p>
    </footer>
</body>
</html>