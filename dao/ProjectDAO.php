<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
class projectDAO extends DAO
{
    private $userDAO;

    private $catDAO;

    private $fileDAO;

    private $commentDAO;

    private $starDAO;

    private $likesDAO;

    public function setUserDAO($userDAO) {
        $this->userDAO = $userDAO;
    }

    public function setCatDAO($catDAO) {
        $this->catDAO = $catDAO;
    }

    public function setFileDAO($fileDAO) {
        $this->fileDAO = $fileDAO;
    }

    public function setCommentDAO($commentDAO) {
        $this->commentDAO = $commentDAO;
    }

    public function setStarDAO($starDAO) {
        $this->starDAO = $starDAO;
    }

    public function setLikesDAO($likesDAO) {
        $this->likesDAO = $likesDAO;
    }

    public function findAllByUser($userId) {
        $user = $this->userDAO->find($userId);
        $sql = "select * from t_projet where usr_xid=? order by proj_id";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($userId));
        $result = $query->fetchAll();

        $projects = array();
        foreach ($result as $row) {
            $projId = $row['proj_id'];
            $project = $this->buildDomainObject($row);
            $project->setUser($user);
            array_push($projects, $project);
        }
        return $projects;
    }

     public function findTopSix() {

        $sql = "select *
                from t_projet
                inner join
                (select  proj_xid  ,count(proj_xid) as count
                from t_likes
                group by proj_xid
                order by count(proj_xid)
                limit 6
                ) d on d.proj_xid = t_projet.proj_id
                order by d.count desc
                ";
        $query = $this->getDb()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        $projects = array();
        foreach ($result as $row) {
            $projId = $row['proj_id'];
            $project = $this->buildDomainObject($row);
            array_push($projects, $project);
        }
        return $projects;
    }


    public function findAllByCat($catId) {
        $cat = $this->catDAO->find($catId);
        $sql = "select * from t_projet where cat_xid=? order by proj_id";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($catId));
        $result = $query->fetchAll();

        $projects = array();
        foreach ($result as $row) {
            $projId = $row['proj_id'];
            $project = $this->buildDomainObject($row);
            $project->setCategory($cat);
            array_push($projects, $project);
        }
        return $projects;
    }

    public function findAllByType($type) {
        $sql = "select * from t_projet where proj_type=? order by proj_id";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($type));
        $result = $query->fetchAll();

        $projects = array();
        foreach ($result as $row) {
            $projId = $row['proj_id'];
            $project = $this->buildDomainObject($row);
            array_push($projects, $project);
        }
        return $projects;
    }

    public function findAllByTypeAndCat($type, $catId) {
        $cat = $this->catDAO->find($catId);
        $sql = "select * from t_projet where cat_xid=? and proj_type = ? order by proj_id";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($catId, $type));
        $result = $query->fetchAll();

        $projects = array();
        foreach ($result as $row) {
            $projId = $row['proj_id'];
            $project = $this->buildDomainObject($row);
            $project->setCategory($cat);
            array_push($projects, $project);
        }
        return $projects;
    }

    // sca : gestion des catégorie du projet
    public function findOwnAllProjectByCat($catId,$userId) {

        $cat = $this->catDAO->find($catId);
        $sql = "select * from t_projet where cat_xid=? and usr_xid = ? order by proj_id";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($catId,$userId));
        $result = $query->fetchAll();


        $projects = array();
        foreach ($result as $row) {
            $projId = $row['proj_id'];
            $project = $this->buildDomainObject($row);
            $project->setCategory($cat);
            array_push($projects, $project);
        }


        return $projects;
    }

    // sca : méthode de recherche sur le titre et/ou la description
    public function findAllByKeyword($keyword) {

        $sql = "select *
                from t_projet
                where proj_title like ?
                order by proj_id";

        $query = $this->getDb()->prepare($sql);
        $params = array("%$keyword%");
      //  $query->bindValue(':keyword', $keyword);
        $query->execute($params);
        //$query->execute();
        $result = $query->fetchAll();

        $projects = array();
        foreach ($result as $row) {
            $projId = $row['proj_id'];
            $project = $this->buildDomainObject($row);
            array_push($projects, $project);
        }
        return $projects;
    }

    /*sca sendMailAfterUpgrade*/
    function sendMailUpgradeProject($message,$to,$subject)
    {
        require_once ("ENV/prod.php");
        require 'dependencies/PHPMailer/src/Exception.php';
        require 'dependencies/PHPMailer/src/PHPMailer.php';
        require 'dependencies/PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'crowdfundingwavre@gmail.com';                 // SMTP username
            $mail->Password = $password;                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('crowdfundingwavre@gmail.com', 'CrowdFunding Wavrien');
            $mail->addAddress($to);
            $mail->addReplyTo('crowdfundingwavre@gmail.com', 'CrowdFunding Wavrien');

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $message;

            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent.';
        }
    }

    public function save(Project $project) {
        $projectData = array(
            'proj_title' => $project->getTitle(),
            'proj_content' => $project->getContent(),
            'proj_max_stars' => $project->getMaxstars(),
            'cat_xid' => $project->getCategory()->getId(),
            'usr_xid' => $project->getUser()->getId(),
            'proj_type' => $project->getType()
            );

        if ($project->getId()) {
            $projectData["proj_view"] = $project->getView();
            $projectData["proj_id"] = $project->getId();
            $sql = "update t_projet set proj_title = :proj_title, proj_content = :proj_content, proj_max_stars = :proj_max_stars, cat_xid = :cat_xid, usr_xid = :usr_xid, proj_type = :proj_type, proj_view = :proj_view where proj_id = :proj_id";
            $query = $this->getDb()->prepare($sql);
            $query->execute($projectData);
        } else {
            $sql = "insert into t_projet (proj_title, proj_content, proj_date, proj_end_date, proj_max_stars, proj_type, cat_xid, usr_xid) values (:proj_title, :proj_content, NOW(), NOW() + INTERVAL 3 MONTH, :proj_max_stars, :proj_type, :cat_xid, :usr_xid)";
            $query = $this->getDb()->prepare($sql);
            $query->execute($projectData);
            $project->setId($this->getDb()->lastInsertId());
        }
    }

    public function deleteAllByUser($userId) {
        $sql = "delete from t_projet where usr_xid=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($userId));
    }
    public function deleteAllByCategory($catId) {
        $sql = "delete from t_projet where cat_xid=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($catId));

    }

    public function delete($id) {
        $sql = "delete from t_projet where proj_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
    }

    public function findAll() {
        $sql = "select * from t_projet order by proj_id desc";
        $query = $this->getDb()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        $projects = array();
        foreach ($result as $row) {
            $projectId = $row['proj_id'];
            array_push($projects, $this->buildDomainObject($row));
        }
        return $projects;
    }

    protected function buildDomainObject($row) {
        $project = new Project();
        $project->setId($row['proj_id']);
        $project->setTitle($row['proj_title']);
        $project->setContent($row['proj_content']);
        $project->setDate($row['proj_date']);
        $project->setEnddate($row['proj_end_date']);
        $project->setMaxstars($row['proj_max_stars']);
        $project->setType($row['proj_type']);
        $project->setView($row['proj_view']);
        if (array_key_exists('usr_xid', $row)) {
            $userId = $row['usr_xid'];
            $user = $this->userDAO->find($userId);
            $project->setUser($user);
        }
        if (array_key_exists('cat_xid', $row)) {
            $catId = $row['cat_xid'];
            $cat = $this->catDAO->find($catId);
            $project->setCategory($cat);
        }
        $project->setFiles($this->fileDAO->findAllByProject($row['proj_id']));
        $project->setComments($this->commentDAO->findAllByProject($row['proj_id']));
        $project->setStars($this->starDAO->findAllByProject($row['proj_id']));
        $project->setLikes($this->likesDAO->findAllByProject($row['proj_id']));

        return $project;
    }

    public function find($id) {
        $sql = "select * from t_projet where proj_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row)
            return $this->buildDomainObject($row);
        else
            return null;
    }
}
