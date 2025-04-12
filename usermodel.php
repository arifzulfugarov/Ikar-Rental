<?php
require_once 'User.php';

class UserModel {
    private $users = [];

    public function __construct() {

        $this->loadUsersFromJson();
        $this->addDefaultAdmin();

    }

    private function loadUsersFromJson() {

        if (file_exists('users.json')) {
            $json = file_get_contents('users.json');
            $data = json_decode($json, true);
            foreach ($data as $userData) {
                $this->users[] = new User(
                    $userData['fullName'],
                    $userData['email'],
                    $userData['password'],
                    $userData['isAdmin']
                );
            }
        }
    }

    private function saveUsersToJson() {

        $data = array_map(function($user) {

            return [
                'fullName' => $user->getFullName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'isAdmin' => $user->isAdmin()
            ];
        }, $this->users);
        file_put_contents('users.json', json_encode($data));
    }

    public function addUser($user) {

        $this->users[] = $user;
        $this->saveUsersToJson();
    }

    public function findUserByEmail($email) {

        foreach ($this->users as $user) {
            if ($user->getEmail() == $email) {
                return $user;
            }
        }
        return null;
    }

    public function findUserByEmailAndPassword($email, $password) {
        
        foreach ($this->users as $user) {
            if ($user->getEmail() == $email && $user->verifyPassword($password)) {
                return $user;
            }
        }
        return null;
    }

    private function addDefaultAdmin() {

        $adminEmail = 'admin@ikarrental.hu';
        if ($this->findUserByEmail($adminEmail) === null) {
            $admin = new User('Admin', $adminEmail, 'admin', true);
            $this->addUser($admin);
        }

    }
}
?>