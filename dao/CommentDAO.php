<?php
class CommentDAO extends DAO
{
    private $projectDAO;

    private $userDAO;

    public function deleteAllByUser($userId) {
        $sql = "delete from t_comment where usr_xid=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($userId));
    }

    public function find($id) {
        $sql = "select * from t_comment where com_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row)
            return $this->buildDomainObject($row);
        else
            return null;
    }

    public function delete($id) {
        $sql = "delete from t_comment where com_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
    }

    public function deleteAllByProject($projectId) {
        $sql = "delete from t_comment where proj_xid=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($projectId));
    }


    public function setProjectDAO($projectDAO) {
        $this->projectDAO = $projectDAO;
    }

    public function setUserDAO($userDAO) {
        $this->userDAO = $userDAO;
    }

    public function findAll() {
        $sql = "select * from t_comment order by com_id desc";
        $query = $this->getDb()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        $entities = array();
        foreach ($result as $row) {
            $id = $row['com_id'];
            array_push($entities, $this->buildDomainObject($row));
        }
        return $entities;
    }

    public function findAllByProject($projectId) {
        //$project = $this->projectDAO->find($projectId);

        $sql = "select * from t_comment where proj_xid=? order by com_id";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($projectId));
        $result = $query->fetchAll();

        $comments = array();
        foreach ($result as $row) {
            $comId = $row['com_id'];
            $comment = $this->buildDomainObject($row);
            //$comment->setProject($project);
            array_push($comments, $comment);
        }
        return $comments;
    }

    protected function buildDomainObject($row) {
        $comment = new Comment();
        $comment->setId($row['com_id']);
        $comment->setContent($row['com_content']);
        $comment->setDate($row['com_date']);

        if (array_key_exists('proj_xid', $row)) {
            $projectId = $row['proj_xid'];
            //$project = $this->projectDAO->find($projectId);
            //$comment->setProject($project);
        }
        if (array_key_exists('usr_xid', $row)) {
            $userId = $row['usr_xid'];
            $user = $this->userDAO->find($userId);
            $comment->setUser($user);
        }

        return $comment;
    }

    public function save($comment) {
        $commentData = array(
            'proj_xid' => $comment->getProject()->getId(),
            'usr_xid' => $comment->getUser()->getId(),
            'com_content' => $comment->getContent(),
            'com_date' => $comment->getdate()
            );

        if ($comment->getId()) {
            $commentData["com_id"] = $comment->getId();
            $sql = "update t_comment set proj_xid = :proj_xid, usr_xid = :usr_xid, com_content = :com_content, com_date = :com_date where com_id = :com_id";
            $query = $this->getDb()->prepare($sql);
            $query->execute($commentData);
        } else {
            $sql = "insert into t_comment (proj_xid, usr_xid, com_content, com_date) values (:proj_xid, :usr_xid, :com_content, :com_date)";
            $query = $this->getDb()->prepare($sql);
            $query->execute($commentData);
            $comment->setId($this->getDb()->lastInsertId());
        }
    }
    public function findAllByUser($userId) {
        $user = $this->userDAO->find($userId);
        $sql = "select * from t_comment where usr_xid=? order by com_id";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($userId));
        $result = $query->fetchAll();

        $comments = array();
        foreach ($result as $row) {
            $comId = $row['com_id'];
            $comment = $this->buildDomainObject($row);
            $comment->setProject($project);
            arrau_push($comments, $comment);
        }
        return $comments;
    }
}
