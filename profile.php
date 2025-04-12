<?php
require_once 'CarModel.php';
require_once 'BookingModel.php';

session_start();

//

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit();
}

$carModel = new CarModel();
$bookingModel = new BookingModel();
$userEmail = $_SESSION['user_email'];

$bookings = array_filter($bookingModel->getBookings(), function($booking) use ($userEmail) {

    return $booking->getUserEmail() === $userEmail;
});

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Profile</title>
</head>
<body>
    <header>
        <h1>Your Reservations</h1>
        <nav>
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_full_name']); ?></span>
            <a href="logout.php" class="button">Logout</a>
        </nav>
    </header>
    <main>
        <h2>Your Reservations</h2>
        <div class="car-list">
            <?php if (!empty($bookings)): ?>
                <?php foreach ($bookings as $booking): ?>
                    <?php $car = $carModel->findCarById($booking->getCarId()); ?>
                    <?php if ($car): ?>
                        <div class="car-item">
                            <img src="<?php echo htmlspecialchars($car->getImage()); ?>" alt="<?php echo htmlspecialchars($car->getModel()); ?>">
                            <div class="car-info">
                                <h3><?php echo htmlspecialchars($car->getModel()); ?></h3>
                                <p>Brand: <?php echo htmlspecialchars($car->getBrand()); ?></p>
                                <p>Year: <?php echo htmlspecialchars($car->getYear()); ?></p>
                                <p>Transmission: <?php echo htmlspecialchars($car->getTransmission()); ?></p>
                                <p>Fuel Type: <?php echo htmlspecialchars($car->getFuelType()); ?></p>
                                <p>Passengers: <?php echo htmlspecialchars($car->getPassengers()); ?></p>
                                <p>Price: <?php echo htmlspecialchars($car->getDailyPriceHuf()); ?> HUF/day</p>
                                <p>Booking Dates: <?php echo htmlspecialchars($booking->getStartDate()); ?> to <?php echo htmlspecialchars($booking->getEndDate()); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No reservations found.</p>
            <?php endif; ?>
        </div>
        <a href="index.php" class="button return-home">Return to Homepage</a>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> iKarRental. All rights reserved.</p>
    </footer>
</body>
</html>