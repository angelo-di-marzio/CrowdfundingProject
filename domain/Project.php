<?php
class Project
{
    private $id;

    private $title;

    private $content;
    private $date;
    private $end_date;
    private $max_stars;
    private $type;
    private $category;
    private $user;
    private $files;
    private $comments;
    private $stars;
    private $likes;
    private $view;

    public function setView($view) {
        $this->view = $view;
    }

    public function getView() {
        return $this->view;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getEnddate() {
        return $this->end_date;
    }

    public function setEnddate($end_date) {
        $this->end_date = $end_date;
        return $this;
    }
    public function getMaxstars() {
        return $this->max_stars;
    }

    public function setMaxstars($max_stars) {
        $this->max_stars = $max_stars;
        return $this;
    }
    public function getCategory() {
        return $this->category;
    }

    public function setCategory($category) {
        $this->category = $category;
        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function getFiles() {
        return $this->files;
    }

    public function setFiles($files) {
        $this->files = $files;
        return $this;
    }

    public function getComments() {
        return $this->comments;
    }

    public function setComments($comments) {
        $this->comments = $comments;
        return $this;
    }

    public function getStars() {
        return $this->stars;
    }

    public function setStars($stars) {
        $this->stars = $stars;
        return $this;
    }

    public function getLikes() {
        return $this->likes;
    }

    public function setLikes($likes) {
        $this->likes = $likes;
        return $this;
    }

    //sca send mail
    public function exportToHtml(){
  
        $messageBuilder = "<table>
               <tr>
                 <th>Titre</th>
                 <th>Description</th>
                 <th>Date</th>
                 <th>Date de fin</th>
                 <th>Nombre d'étoile atteint</th>
                 <th>Type</th>
                 <th>Vus</th>
               </tr>
               <tr>
                 <td>".$this->getTitle()."</td>
                 <td>".$this->getContent()."</td>
                 <td>".$this->getDate()."</td>
                 <td>".$this->getEnddate()."</td>
                 <td>".$this->getMaxstars()."</td>
                 <td>".$this->getType()."</td>
                 <td>".$this->getView()."</td>
               </tr>  
               </table>           
               ";

        return $messageBuilder;
    }
}
