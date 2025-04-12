<?php
require_once 'CarModel.php';

session_start();

$carModel = new CarModel();

$filters = [
    'transmission' => $_GET['transmission'] ?? '',
    'passengers' => $_GET['passengers'] ?? '',
    'min_price' => $_GET['min_price'] ?? '',
    'max_price' => $_GET['max_price'] ?? '',
    'start_date' => $_GET['start_date'] ?? '',
    'end_date' => $_GET['end_date'] ?? ''
];

$cars = $carModel->filterCars($filters);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>iKarRental - Home</title>
    <script>
        function validateFilters() {
            const passengers = document.querySelector('input[name="passengers"]');
            const minPrice = document.querySelector('input[name="min_price"]');
            const maxPrice = document.querySelector('input[name="max_price"]');
            const startDate = document.querySelector('input[name="start_date"]');
            const endDate = document.querySelector('input[name="end_date"]');

            if (passengers.value < 0) {
                alert('Passengers must be a positive number.');
                return false;
            }
            if (minPrice.value < 0) {
                alert('Min price must be a positive number.');
                return false;
            }
            if (maxPrice.value < 0) {
                alert('Max price must be a positive number.');
                return false;
            }
            if (startDate.value && endDate.value && new Date(startDate.value) > new Date(endDate.value)) {
                alert('Start date must be before end date.');
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <header>
        <h1>Welcome to iKarRental</h1>
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
        <div class="filter-banner">
            <form method="GET" action="" onsubmit="return validateFilters()">
                <select name="transmission">
                    <option value="">All Transmissions</option>
                    <option value="Automatic" <?php if ($filters['transmission'] == 'Automatic') echo 'selected'; ?>>Automatic</option>
                    <option value="Manual" <?php if ($filters['transmission'] == 'Manual') echo 'selected'; ?>>Manual</option>
                </select>
                <input type="number" name="passengers" placeholder="Min passengers" value="<?php echo htmlspecialchars($filters['passengers']); ?>" min="0">
                <input type="number" name="min_price" placeholder="Min price" value="<?php echo htmlspecialchars($filters['min_price']); ?>" min="0">
                <input type="number" name="max_price" placeholder="Max price" value="<?php echo htmlspecialchars($filters['max_price']); ?>" min="0">
                <input type="date" name="start_date" value="<?php echo htmlspecialchars($filters['start_date']); ?>">
                <input type="date" name="end_date" value="<?php echo htmlspecialchars($filters['end_date']); ?>">
                <button type="submit">Filter</button>
            </form>
        </div>
        <h2>Available Cars</h2>
        <div class="car-list">
            <?php if (!empty($cars)): ?>
                <?php foreach ($cars as $car): ?>
                    <div class="car-item">
                        <img src="<?php echo htmlspecialchars($car->getImage()); ?>" alt="<?php echo htmlspecialchars($car->getModel()); ?>">
                        <div class="car-info">
                            <h3><a href="carDetails.php?id=<?php echo $car->getId(); ?>"><?php echo htmlspecialchars($car->getModel()); ?></a></h3>
                            <p>Brand: <?php echo htmlspecialchars($car->getBrand()); ?></p>
                            <p>Year: <?php echo htmlspecialchars($car->getYear()); ?></p>
                            <p>Transmission: <?php echo htmlspecialchars($car->getTransmission()); ?></p>
                            <p>Fuel Type: <?php echo htmlspecialchars($car->getFuelType()); ?></p>
                            <p>Passengers: <?php echo htmlspecialchars($car->getPassengers()); ?></p>
                            <p>Price: <?php echo htmlspecialchars($car->getDailyPriceHuf()); ?> HUF/day</p>
                            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                                <form method="POST" action="adminProfile.php" style="display:inline;">
                                    <input type="hidden" name="car_id" value="<?php echo $car->getId(); ?>">
                                    <button type="submit" name="delete_car" class="button delete">Delete</button>
                                </form>
                                <a href="edit.php?id=<?php echo $car->getId(); ?>" class="button">Edit</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No cars available at the moment.</p>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> iKarRental. All rights reserved.</p>
    </footer>
</body>
</html>