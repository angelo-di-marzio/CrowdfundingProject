<?php
class StarDAO extends DAO
{
    private $projectDAO;

    private $userDAO;

    public function deleteAllByUser($userId) {
        $sql = "delete from t_stars where usr_xid=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($userId));
    }

    public function find($id) {
        $sql = "select * from t_stars where star_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row)
            return $this->buildDomainObject($row);
        else
            return null;
    }

    public function delete($id) {
        $sql = "delete from t_stars where star_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
    }

    public function deleteAllByProject($projectId) {
        $sql = "delete from t_stars where proj_xid=?";
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
        $sql = "select * from t_stars order by star_id desc";
        $query = $this->getDb()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        $entities = array();
        foreach ($result as $row) {
            $id = $row['star_id'];
            array_push($entities, $this->buildDomainObject($row));
        }
        return $entities;
    }

    public function findAllByProject($projectId) {
        //$project = $this->projectDAO->find($projectId);

        $sql = "select * from t_stars where proj_xid=? order by star_id";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($projectId));
        $result = $query->fetchAll();

        $stars = array();
        foreach ($result as $row) {
            $starId = $row['star_id'];
            $star = $this->buildDomainObject($row);
            //$star->setProject($project);
            array_push($stars, $star);
        }
        return $stars;
    }

    protected function buildDomainObject($row) {
        $star = new Star();
        $star->setId($row['star_id']);
        $star->setAmount($row['star_amount']);

        if (array_key_exists('proj_xid', $row)) {
            $projectId = $row['proj_xid'];
            //$project = $this->projectDAO->find($projectId);
            $star->setProject($projectId);
        }
        if (array_key_exists('usr_xid', $row)) {
            $userId = $row['usr_xid'];
            $user = $this->userDAO->find($userId);
            $star->setUser($user);
        }

        return $star;
    }

    public function save($star) {
        $starData = array(
            'proj_xid' => $star->getProject()->getId(),
            'usr_xid' => $star->getUser()->getId(),
            'star_amount' => $star->getAmount()

            );

        if ($star->getId()) {
            $starData['star_id'] = $star->getId();
            $sql = "update t_stars set proj_xid = :proj_xid, usr_xid = :usr_xid, star_amount = :star_amount where star_id = :star_id";
            $query = $this->getDb()->prepare($sql);
            $query->execute($starData);
        } else {
            $sql = "insert into t_stars (proj_xid, usr_xid, star_amount) values (:proj_xid, :usr_xid, :star_amount)";
            $query = $this->getDb()->prepare($sql);
            $query->execute($starData);
            $star->setId($this->getDb()->lastInsertId());
        }
    }
    public function findAllByUser($userId) {
        $user = $this->userDAO->find($userId);
        $sql = "select * from t_stars where usr_xid=? order by star_id desc";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($userId));
        $result = $query->fetchAll();

        $stars = array();
        foreach ($result as $row) {
            $starId = $row['star_id'];
            $star = $this->buildDomainObject($row);
            $stars[$starId] = $star;
        }
        return $stars;
    }
}
