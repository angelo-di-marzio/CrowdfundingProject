<?php
class File
{
    private $id;

    private $proj_xid;

    private $user_xid;

    private $url;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getProject() {
        return $this->proj_xid;
    }

    public function setProject($proj_xid) {
        $this->proj_xid = $proj_xid;
        return $this;
    }

    /*sca */
    public function getUser() {
        return $this->user_xid;
    }
     /*sca */
    public function setUser($user_xid) {
        $this->user_xid = $user_xid;
        return $this;
    }


    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }
}
