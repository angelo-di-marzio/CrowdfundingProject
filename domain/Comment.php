<?php
class Comment
{
    private $id;

    private $user;

    private $date;

    private $content;

    private $project;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getProject() {
        return $this->project;
    }

    public function setProject($project) {
        $this->project = $project;
        return $this;
    }
}
