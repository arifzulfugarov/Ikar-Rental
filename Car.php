<?php
class Car {

    //here I am creating a class for the car object and defining the properties of the car object
    private $id;
    private $brand;
    private $model;
    private $year;
    private $transmission;
    private $fuelType;
    private $passengers;
    private $dailyPriceHuf;
    private $image;

    public function __construct($id, $brand, $model, $year, $transmission, $fuelType, $passengers, $dailyPriceHuf, $image) {
        $this->id = $id;
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
        $this->transmission = $transmission;
        $this->fuelType = $fuelType;
        $this->passengers = $passengers;
        $this->dailyPriceHuf = $dailyPriceHuf;
        $this->image = $image;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getBrand() {
        return $this->brand;
    }

    public function setBrand($brand) {
        $this->brand = $brand;
    }

    public function getModel() {
        return $this->model;
    }

    public function setModel($model) {
        $this->model = $model;
    }

    public function getYear() {
        return $this->year;
    }

    public function setYear($year) {
        $this->year = $year;
    }

    public function getTransmission() {
        return $this->transmission;
    }

    public function setTransmission($transmission) {
        $this->transmission = $transmission;
    }

    public function getFuelType() {
        return $this->fuelType;
    }

    public function setFuelType($fuelType) {
        $this->fuelType = $fuelType;
    }

    public function getPassengers() {
        return $this->passengers;
    }

    public function setPassengers($passengers) {
        $this->passengers = $passengers;
    }

    public function getDailyPriceHuf() {
        return $this->dailyPriceHuf;
    }

    public function setDailyPriceHuf($dailyPriceHuf) {
        $this->dailyPriceHuf = $dailyPriceHuf;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }
}
?>