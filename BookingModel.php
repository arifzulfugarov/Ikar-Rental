<?php
require_once 'Booking.php';

//here I am creating a class called BookingModel so that I can create a new booking object

class BookingModel {
    private $bookings = [];

    public function __construct() {
        $this->loadBookingsFromJson();
    }

    private function loadBookingsFromJson() {
        if (file_exists('bookings.json')) {
            $json = file_get_contents('bookings.json');
            $data = json_decode($json, true);
            foreach ($data as $bookingData) {
                $this->bookings[] = new Booking(
                    $bookingData['carId'],
                    $bookingData['userEmail'],
                    $bookingData['startDate'],
                    $bookingData['endDate'],
                    $bookingData['id'] ?? null
                );
            }
        }
    }

    private function saveBookingsToJson() {
        $data = array_map(function($booking) {
            return [
                'id' => $booking->getId(),
                'carId' => $booking->getCarId(),
                'userEmail' => $booking->getUserEmail(),
                'startDate' => $booking->getStartDate(),
                'endDate' => $booking->getEndDate()
            ];
        }, $this->bookings);
        file_put_contents('bookings.json', json_encode($data));
    }

    public function addBooking($booking) {
        $this->bookings[] = $booking;
        $this->saveBookingsToJson();
    }

    public function isCarAvailable($carId, $startDate, $endDate) {
        foreach ($this->bookings as $booking) {
            if ($booking->getCarId() == $carId) {
                if (($startDate >= $booking->getStartDate() && $startDate <= $booking->getEndDate()) ||
                    ($endDate >= $booking->getStartDate() && $endDate <= $booking->getEndDate()) ||
                    ($startDate <= $booking->getStartDate() && $endDate >= $booking->getEndDate())) {
                    return false;
                }
            }
        }
        return true;
    }

    public function getBookings() {
        return $this->bookings;
    }

    public function deleteBookingsByCarId($carId) {
        $this->bookings = array_filter($this->bookings, function($booking) use ($carId) {
            return $booking->getCarId() != $carId;
        });
        $this->saveBookingsToJson();
    }

    public function deleteBookingById($bookingId) {
        $this->bookings = array_filter($this->bookings, function($booking) use ($bookingId) {
            return $booking->getId() != $bookingId;
        });
        $this->saveBookingsToJson();
    }

    public function updateBookingsByCarId($carId, $newCarId) {
        foreach ($this->bookings as $booking) {
            if ($booking->getCarId() == $carId) {
                $booking->setCarId($newCarId);
            }
        }
        $this->saveBookingsToJson();
    }
}
?>