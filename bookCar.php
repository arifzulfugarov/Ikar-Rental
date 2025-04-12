<?php
require_once 'CarModel.php';
require_once 'BookingModel.php';

session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit();
}

$carModel = new CarModel();
$bookingModel = new BookingModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carId = $_POST['car_id'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $userEmail = $_SESSION['user_email'];

    $car = $carModel->findCarById($carId);

    if ($car && $startDate && $endDate && $userEmail) {
        if (strtotime($startDate) >= strtotime($endDate)) {
            header('Location: bookingResult.php?success=0&error=invalid_dates');
            exit();
        }
        if ($bookingModel->isCarAvailable($carId, $startDate, $endDate)) {
            $booking = new Booking($carId, $userEmail, $startDate, $endDate);
            $bookingModel->addBooking($booking);
            $totalPrice = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24) * $car->getDailyPriceHuf();
            header('Location: bookingResult.php?success=1&car_id=' . $carId . '&start_date=' . $startDate . '&end_date=' . $endDate . '&total_price=' . $totalPrice);
            exit();
        } else {
            header('Location: bookingResult.php?success=0&error=unavailable');
            exit();
        }
    } else {
        header('Location: bookingResult.php?success=0&error=invalid_request');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>