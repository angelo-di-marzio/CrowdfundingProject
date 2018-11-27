<?php
class User
{
    private $id;

    private $username;

    private $password;

    private $salt;

    private $role;

    private $active;

    private $email;

    private $avatar;

    private $lastname;

    private $firstname;

    private $blocked;

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function getId() {
        return $this->id;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }
    public function getEmail() {
        return $this->email;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
        return $this;
    }
    public function getLastname() {
        return $this->lastname;
    }

    public function setFirstname($firstname) {
        $this->firstname = utf8_encode($firstname);
        return $this;
    }
    public function getFirstname() {
        return $this->firstname;
    }


    public function setAvatar($avatar) {
        $this->avatar = $avatar;
        return $this;
    }

      public function getAvatar() {
        return $this->avatar;
    }
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    public function getRoles()
    {
        return array($this->getRole());
    }

    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setBlocked($blocked) {
        $this->blocked = $blocked;
        return $this;
    }

    public function getBlocked()
    {
        return $this->blocked;
    }
}
