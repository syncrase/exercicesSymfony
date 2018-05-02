<?php

namespace App\Core\User\Forms;

/**
 * Description of SignUpData
 *
 * @author Pierre
 */
class SignUpData {

    private $username;

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    private $password;

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    private $email;

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

}
