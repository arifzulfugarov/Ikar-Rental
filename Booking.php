<?php
class Booking {
    private $id;
    private $carId;
    private $userEmail;
    private $startDate;
    private $endDate;

    public function __construct($carId, $userEmail, $startDate, $endDate, $id = null) {
    //I am using construct for the Booking class to create a new booking object
        $this->id = $id ?? uniqid();
        $this->carId = $carId;
        $this->userEmail = $userEmail;
        $this->startDate = $startDate;
        $this->endDate = $endDate;

    }

    public function getId() {
        return $this->id;
    }

    public function getCarId() {
        return $this->carId;
    }

    public function setCarId($carId) {
        $this->carId = $carId;
    }

    public function getUserEmail() {
        return $this->userEmail;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }
}
?>