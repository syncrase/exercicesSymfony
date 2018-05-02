<?php

namespace App\Core\User\Forms;

/**
 * Description of SignInData
 *
 * @author Pierre
 */
class SignInData {

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

}
