<?php
require_once 'CarModel.php';

session_start();

//i am editing a car by its id so that the admin can update the car details

if (!isset($_SESSION['user_email']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit();
}

$carModel = new CarModel();
$carId = $_GET['id'] ?? null;
$car = $carId ? $carModel->findCarById($carId) : null;

if (!$car) {
    header('Location: adminProfile.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $transmission = $_POST['transmission'];
    $fuel_type = $_POST['fuel_type'];
    $passengers = $_POST['passengers'];
    $daily_price_huf = $_POST['daily_price_huf'];
    $image = $_POST['image'];

    if ($brand && $model && $year && $transmission && $fuel_type && $passengers > 0 && $daily_price_huf > 0 && $image) {
        $car->setBrand($brand);
        $car->setModel($model);
        $car->setYear($year);
        $car->setTransmission($transmission);
        $car->setFuelType($fuel_type);
        $car->setPassengers($passengers);
        $car->setDailyPriceHuf($daily_price_huf);
        $car->setImage($image);
        $carModel->updateCar($car);
        header('Location: index.php');
        exit();
    } else {
        $message = "All fields are required and must be valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edit Car</title>
    <script>
        function validateForm() {
            const passengers = document.querySelector('input[name="passengers"]');
            const dailyPrice = document.querySelector('input[name="daily_price_huf"]');
            const messageElement = document.getElementById('message');

            if (passengers.value <= 0) {
                messageElement.textContent = 'Passengers must be a positive number.';
                return false;
            }
            if (dailyPrice.value <= 0) {
                messageElement.textContent = 'Daily price must be a positive number.';
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <header>
        <h1>Edit Car</h1>
        <nav>
            <a href="index.php" class="button">Home</a>
            <a href="logout.php" class="button">Logout</a>
        </nav>
    </header>
    <main>
        <form method="POST" action="edit.php?id=<?= $car->getId() ?>" class="add-car-form" novalidate onsubmit="return validateForm()">
            <input type="text" name="brand" placeholder="Brand" required value="<?= htmlspecialchars($car->getBrand()) ?>">
            <input type="text" name="model" placeholder="Model" required value="<?= htmlspecialchars($car->getModel()) ?>">
            <input type="number" name="year" placeholder="Year" required value="<?= htmlspecialchars($car->getYear()) ?>">
            <input type="text" name="transmission" placeholder="Transmission" required value="<?= htmlspecialchars($car->getTransmission()) ?>">
            <input type="text" name="fuel_type" placeholder="Fuel Type" required value="<?= htmlspecialchars($car->getFuelType()) ?>">
            <input type="number" name="passengers" placeholder="Passengers" required value="<?= htmlspecialchars($car->getPassengers()) ?>" min="1">
            <input type="number" name="daily_price_huf" placeholder="Daily Price (HUF)" required value="<?= htmlspecialchars($car->getDailyPriceHuf()) ?>" min="1">
            <input type="text" name="image" placeholder="Image URL" required value="<?= htmlspecialchars($car->getImage()) ?>">
            <button type="submit">Update Car</button>
        </form>
        <p id="message"><?= $message ?></p>
    </main>
    <footer>
        <p>&copy; <?= date("Y") ?> iKarRental. All rights reserved.</p>
    </footer>
</body>
</html>