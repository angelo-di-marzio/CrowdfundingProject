<?php
class Star
{
    private $id;

    private $usr_xid;

    private $proj_xid;

    private $amount;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getUser() {
        return $this->usr_xid;
    }

    public function setUser($usr_xid) {
        $this->usr_xid = $usr_xid;
        return $this;
    }
    public function getProject() {
        return $this->proj_xid;
    }

    public function setProject($proj_xid) {
        $this->proj_xid = $proj_xid;
        return $this;
    }
    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
        return $this;
    }
}
