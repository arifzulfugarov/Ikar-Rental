# iKarRental – Car Rental Web Application

## 📚 Project Description
iKarRental is a PHP-based web application developed for a car rental business.  
It allows users to browse available cars, register and log in, and book vehicles for specific time periods.  
An administrator can manage cars (add, edit, delete) and view all bookings.

This project was created as part of the Web Programming – PHP Assignment at ELTE.

## 🚀 Features

### For Guests
- View all available cars on the homepage.
- Filter cars by:
  - Availability within a date range
  - Transmission type (Automatic/Manual)
  - Passenger capacity
  - Daily rental price
- View detailed information about each car.

### For Registered Users
- User registration and login functionality.
- Book a car for specific dates.
- View personal booking history on a profile page.
- Logout functionality accessible from any page.

### For Administrators
- Separate admin login (default admin credentials).
- Add new cars with error handling.
- Edit and delete existing cars.
- View and delete all bookings from the admin dashboard.

## 🛠 Technologies Used
- PHP (Core PHP, no frameworks)
- HTML, CSS
- JavaScript (for client-side validation)
- SQLite (data storage)
- Bootstrap (for responsive, mobile-friendly design)

- ## 🚀 Dockerized Setup

This project is fully containerized using Docker and Docker Compose.

### 🧱 Services:
- **Web**: Apache + PHP 8.2 (custom Dockerfile)
- **Database**: MySQL 8.0 (with preset user and DB)
- **Optional**: phpMyAdmin (GUI for MySQL access)

### 🛠️ How to Run

1. Make sure [Docker Desktop](https://www.docker.com/products/docker-desktop) is installed and running.
2. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/Ikar-Rental.git
   cd Ikar-Rental


## 🗄️ Data Models

### Car
- `id` (integer)
- `brand` (string)
- `model` (string)
- `year` (integer)
- `transmission` (string)
- `fuel_type` (string)
- `passengers` (integer)
- `daily_price_huf` (integer)
- `image` (string URL)

### User
- `full_name` (string)
- `email` (string, unique)
- `password` (string, hashed)
- `is_admin` (boolean)

### Booking
- `start_date` (date)
- `end_date` (date)
- `user_email` (string, linked to User)
- `car_id` (integer, linked to Car)

## 🧰 Setup Instructions

1. Clone the repository:
   ```bash
   git clone https://github.com/arifzulfugarov/Ikar-Rental.git
