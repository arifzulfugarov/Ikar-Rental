<?php
require_once 'BookingModel.php';

//i am deleting a booking by its id from the database

session_start();

if (!isset($_SESSION['user_email']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit();
}

$bookingModel = new BookingModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_booking'])) {

    $bookingId = $_POST['booking_id'];
    $bookingModel->deleteBookingById($bookingId);
    header('Location: adminProfile.php');
    exit();
} 
else {
    header('Location: adminProfile.php');
    exit();
    }
?>