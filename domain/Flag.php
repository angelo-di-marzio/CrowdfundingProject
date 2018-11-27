<?php
class Flag
{
    private $id;

    private $amount;

    private $user;

    private $comment;

    private $project;

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

     public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
        return $this;
    }

    public function getComment() {
        return $this->comment;
    }

    public function setComment($comment) {
        $this->comment = $comment;
        return $this;
    }
    public function getproject() {
        return $this->project;
    }

    public function setproject($project) {
        $this->project = $project;
        return $this;
    }
}
