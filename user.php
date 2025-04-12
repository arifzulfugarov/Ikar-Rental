<?php
class User {
    
    private $fullName;
    private $email;
    private $password;
    private $isAdmin;

    public function __construct($fullName, $email, $password, $isAdmin = false) {

        $this->fullName = $fullName;
        $this->email = $email;
        $this->password = $password; 
        $this->isAdmin = $isAdmin;
    }

    public function getFullName() {

        return $this->fullName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function isAdmin() {
        return $this->isAdmin;
    }

    public function verifyPassword($password) {
        return $this->password === $password;
    }
}
?>