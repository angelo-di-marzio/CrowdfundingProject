<?php
class LikeDAO extends DAO
{
    private $projectDAO;

    private $userDAO;

    public function deleteAllByUser($userId) {
        $sql = "delete from t_likes where usr_xid=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($userId));
    }

    public function find($id) {

        $sql = "select * from t_likes where like_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row)
            return $this->buildDomainObject($row);
        else
            return null;
    }

    public function delete($id) {
        $sql = "delete from t_likes where com_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
    }

    public function deleteAllByProject($projectId) {
        $sql = "delete from t_likes where proj_xid=?";
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
        $sql = "select * from t_likes order by like_id desc";
        $query = $this->getDb()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        $entities = array();
        foreach ($result as $row) {
            $id = $row['like_id'];
            array_push($entities, $this->buildDomainObject($row));
        }
        return $entities;
    }

    public function findAllByproject($projectId) {
        //$project = $this->projectDAO->find($projectId);
        $sql = "select like_id, usr_xid from t_likes where proj_xid=? order by like_id";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($projectId));
        $result = $query->fetchAll();
        $likes = array();
        foreach ($result as $row) {
            $likeId = $row['like_id'];
            $like = $this->buildDomainObject($row);
            array_push($likes, $like);
            //$like->setProject($project);
            //$likes[$likeId] = $like;
        }
        return $likes;
    }

    public function findByProjectAndUser($projectId, $userId) {

        $sql = "select * from t_likes where proj_xid=? and usr_xid=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($projectId, $userId));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row)
            return $this->buildDomainObject($row);
        else
            return null;
    }

    protected function buildDomainObject($row) {
        $like = new like();
        $like->setId($row['like_id']);

        if (array_key_exists('proj_xid', $row)) {
            $projectId = $row['proj_xid'];
            //$project = $this->projectDAO->find($projectId);
            //$like->setProject($project);
        }
        if (array_key_exists('usr_xid', $row)) {
            $userId = $row['usr_xid'];
            //$user = $this->userDAO->find($userId);
            //$like->setUser($user);
        }
        return $like;
    }

    public function save($like) {
        $likeData = array(
            'proj_xid' => $like->getProject()->getId(),
            'usr_xid' => $like->getUser()->getId()
            );

        if ($like->getId()) {
            $likeData["like_id"] = $like->getId();
            $sql = "update t_likes set proj_xid = :proj_xid, usr_xid = :usr_xid where like_id = :like_id";
            $query = $this->getDb()->prepare($sql);
            $query->execute($likeData);
        } else {
            $sql = "insert into t_likes (proj_xid, usr_xid) values (:proj_xid, :usr_xid)";
            $query = $this->getDb()->prepare($sql);
            $query->execute($likeData);
            $like->setId($this->getDb()->lastInsertId());
        }
    }
}
