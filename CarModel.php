<?php
require_once 'Car.php';
require_once 'BookingModel.php';

class CarModel {
    private $cars = [];
    private $bookingModel;

    public function __construct() {
        $this->loadCarsFromJson();
        $this->bookingModel = new BookingModel();
    }

    private function loadCarsFromJson() {
        if (file_exists('cars.json')) {
            $json = file_get_contents('cars.json');
            $data = json_decode($json, true);
            foreach ($data as $carData) {
                $this->cars[] = new Car(
                    $carData['id'],
                    $carData['brand'],
                    $carData['model'],
                    $carData['year'],
                    $carData['transmission'],
                    $carData['fuel_type'],
                    $carData['passengers'],
                    $carData['daily_price_huf'],
                    $carData['image']
                );
            }
        }
    }

    private function saveCarsToJson() {
        $data = array_map(function($car) {
            return [
                'id' => $car->getId(),
                'brand' => $car->getBrand(),
                'model' => $car->getModel(),
                'year' => $car->getYear(),
                'transmission' => $car->getTransmission(),
                'fuel_type' => $car->getFuelType(),
                'passengers' => $car->getPassengers(),
                'daily_price_huf' => $car->getDailyPriceHuf(),
                'image' => $car->getImage()
            ];
        }, $this->cars);
        file_put_contents('cars.json', json_encode($data));
    }

    public function getAllCars() {
        return $this->cars;
    }

    public function addCar($car) {
        $car->setId($this->generateNewId());
        $this->cars[] = $car;
        $this->saveCarsToJson();
    }

    public function updateCar($car) {
        foreach ($this->cars as &$existingCar) {
            if ($existingCar->getId() == $car->getId()) {
                $existingCar = $car;
                break;
            }
        }
        $this->saveCarsToJson();
    }

    public function deleteCar($carId) {
        $this->cars = array_filter($this->cars, function($car) use ($carId) {
            return $car->getId() != $carId;
        });
        $this->saveCarsToJson();
    }

    private function generateNewId() {
        $maxId = 0;
        foreach ($this->cars as $car) {
            if ($car->getId() > $maxId) {
                $maxId = $car->getId();
            }
        }
        return $maxId + 1;
    }

    public function filterCars($filters) {
        return array_filter($this->cars, function($car) use ($filters) {
            if (!empty($filters['transmission']) && $car->getTransmission() != $filters['transmission']) {
                return false;
            }
            if (!empty($filters['passengers']) && $car->getPassengers() < $filters['passengers']) {
                return false;
            }
            if (!empty($filters['min_price']) && $car->getDailyPriceHuf() < $filters['min_price']) {
                return false;
            }
            if (!empty($filters['max_price']) && $car->getDailyPriceHuf() > $filters['max_price']) {
                return false;
            }
            if (!empty($filters['start_date']) && !empty($filters['end_date']) && !$this->bookingModel->isCarAvailable($car->getId(), $filters['start_date'], $filters['end_date'])) {
                return false;
            }
            return true;
        });
    }

    public function findCarById($carId) {
        foreach ($this->cars as $car) {
            if ($car->getId() == $carId) {
                return $car;
            }
        }
        return null;
    }
}
?>