<?php

/**
 * Description of User
 * cf. https://symfony.com/doc/current/security/entity_provider.html
 *
 * @author Pierre
 */

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface {

    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $username;

    /**
     * @MongoDB\Field(type="string")
     */
    private $password;

    /**
     * @MongoDB\Field(type="string")
     */
    private $email;

    /**
     * @ MongoDB\Field(type="string")
     */
//    private $isActive;
//    public function __construct() {
//        $this->isActive = true;
//        // may not be needed, see section on salt below
//        // $this->salt = md5(uniqid('', true));
//    }
    public function getId() {
        return $this->id;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRoles() {
        return array('ROLE_USER');
    }

    //

    public function eraseCredentials() {
        
    }

    public function getSalt() {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    /** @see \Serializable::serialize() */
//    public function serialize() {
//        return serialize(array(
//            $this->id,
//            $this->username,
//            $this->password,
//                // see section on salt below
//                // $this->salt,
//        ));
//    }

    /** @see \Serializable::unserialize() */
//    public function unserialize($serialized) {
//        list (
//                $this->id,
//                $this->username,
//                $this->password,
//                // see section on salt below
//                // $this->salt
//                ) = unserialize($serialized, ['allowed_classes' => false]);
//    }
}
