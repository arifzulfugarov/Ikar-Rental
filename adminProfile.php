<?php
require_once 'CarModel.php';
require_once 'BookingModel.php';

session_start();

if (!isset($_SESSION['user_email']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit();
}

//here i am requiring the CarModel and BookingModel classes

$carModel = new CarModel();
$bookingModel = new BookingModel();
$cars = $carModel->getAllCars();
$bookings = $bookingModel->getBookings();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['delete_car'])) {
        $carId = $_POST['car_id'];
        $carModel->deleteCar($carId);
        $bookingModel->deleteBookingsByCarId($carId);
        header('Location: index.php');
        exit();
    } 
    elseif (isset($_POST['add_car'])) {
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $transmission = $_POST['transmission'];
        $fuel_type = $_POST['fuel_type'];
        $passengers = $_POST['passengers'];
        $daily_price_huf = $_POST['daily_price_huf'];
        $image = $_POST['image'];

        if ($brand && $model && $year && $transmission && $fuel_type && $passengers && $daily_price_huf && $image) {
            $car = new Car(null, $brand, $model, $year, $transmission, $fuel_type, $passengers, $daily_price_huf, $image);
            $carModel->addCar($car);
            header('Location: index.php');
            exit();
        } else {
            $message = "All fields are required.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Admin Profile</title>
</head>
<body>
    <header>
        <h1>Admin Profile</h1>
        <nav>
            <span>Welcome, <?= htmlspecialchars($_SESSION['user_full_name']) ?></span>
            <a href="index.php" class="button">Home</a>
            <a href="logout.php" class="button">Logout</a>
        </nav>
    </header>
    <main>
        <h2>All Bookings</h2>
        <ul>
            <?php if (!empty($bookings)): ?>
                <?php foreach ($bookings as $booking): ?>
                    <li>
                        Car ID: <?= htmlspecialchars($booking->getCarId()) ?>,
                        User Email: <?= htmlspecialchars($booking->getUserEmail()) ?>,
                        Start Date: <?= htmlspecialchars($booking->getStartDate()) ?>,
                        End Date: <?= htmlspecialchars($booking->getEndDate()) ?>
                        <form method="POST" action="deleteBooking.php" style="display:inline;">
                            <input type="hidden" name="booking_id" value="<?= $booking->getId() ?>">
                            <button type="submit" name="delete_booking" class="button delete">Delete Booking</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No bookings found.</li>
            <?php endif; ?>
        </ul>
        <h2>Manage Cars</h2>
        <div class="car-list">
            <?php if (!empty($cars)): ?>
                <?php foreach ($cars as $car): ?>
                    <div class="car-item">
                        <img src="<?= htmlspecialchars($car->getImage()) ?>" alt="<?= htmlspecialchars($car->getModel()) ?>">
                        <div class="car-info">
                            <h3><?= htmlspecialchars($car->getModel()) ?></h3>
                            <p>Brand: <?= htmlspecialchars($car->getBrand()) ?></p>
                            <p>Year: <?= htmlspecialchars($car->getYear()) ?></p>
                            <p>Transmission: <?= htmlspecialchars($car->getTransmission()) ?></p>
                            <p>Fuel Type: <?= htmlspecialchars($car->getFuelType()) ?></p>
                            <p>Passengers: <?= htmlspecialchars($car->getPassengers()) ?></p>
                            <p>Price: <?= htmlspecialchars($car->getDailyPriceHuf()) ?> HUF/day</p>
                            <form method="POST" action="adminProfile.php" style="display:inline;">
                                <input type="hidden" name="car_id" value="<?= $car->getId() ?>">
                                <button type="submit" name="delete_car" class="button delete">Delete</button>
                            </form>
                            <a href="edit.php?id=<?= $car->getId() ?>" class="button">Edit</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No cars found.</p>
            <?php endif; ?>
        </div>

        <h3>Add New Car</h3>
        <form method="POST" action="adminProfile.php" class="add-car-form" novalidate>
            <input type="text" name="brand" placeholder="Brand" required>
            <input type="text" name="model" placeholder="Model" required>
            <input type="number" name="year" placeholder="Year" required>
            <input type="text" name="transmission" placeholder="Transmission" required>
            <input type="text" name="fuel_type" placeholder="Fuel Type" required>
            <input type="number" name="passengers" placeholder="Passengers" required>
            <input type="number" name="daily_price_huf" placeholder="Daily Price (HUF)" required>
            <input type="text" name="image" placeholder="Image URL" required>
            <button type="submit" name="add_car">Add Car</button>
        </form>

        <?php if (isset($message)): ?>
            <p><?= $message ?></p>

        <?php endif; ?>

    </main>
    <footer>

        <p>&copy; <?= date("Y") ?> iKarRental. All rights reserved.</p>
    </footer>
</body>
</html>