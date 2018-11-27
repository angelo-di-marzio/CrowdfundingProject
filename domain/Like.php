<?php
class Like
{
    private $id;

    private $user;

    private $projet;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

   public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }
    public function getProject() {
        return $this->projet;
    }

    public function setProject($projet) {
        $this->projet = $projet;
        return $this;
    }
}
