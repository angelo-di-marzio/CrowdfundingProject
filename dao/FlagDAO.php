<?php
class FlagDAO extends DAO
{
    private $projectDAO;

    private $commentDAO;

    private $userDAO;

    public function setCommentDAO($commentDAO) {
        $this->commentDAO = $commentDAO;
    }

    public function setUserDAO($userDAO) {
        $this->userDAO = $userDAO;
    }

    public function setProjectDAO($projectDAO) {
        $this->projectDAO = $projectDAO;
    }

    public function delete($id) {
        $sql = "delete from t_flag where flag_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
    }

    public function deleteCommentsRelatedToProject($projectId) {
        $sql = "delete from t_flag where proj_xid=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($projectId));
    }

    public function findAll() {
        $sql = "select * from t_flag order by flag_id desc";
        $query = $this->getDb()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        $entities = array();
        foreach ($result as $row) {
            $id = $row['flag_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    public function findAllProject() {
        $sql = "select * from t_flag where proj_xid IS NOT NULL order by flag_id desc";
        $query = $this->getDb()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        $entities = array();
        foreach ($result as $row) {
            $id = $row['flag_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }

        return $entities;
    }

    public function findAllComment() {
        $sql = "select * from t_flag where com_xid IS NOT NULL order by flag_id desc";
        $query = $this->getDb()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        $entities = array();
        foreach ($result as $row) {
            $id = $row['flag_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

     public function find($id) {
        $sql = "select * from t_flag where flag_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row)
            return $this->buildDomainObject($row);
        else
            return null;

    }
    public function findAllByProject($projectId) {
        $project = $this->projectDAO->find($projectId);
        $sql = "select * from t_flag where proj_xid=? order by flag_id";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($projectId));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row)
            return $this->buildDomainObject($row);
        else
            return null;
        /*$result = $query->fetchAll();

        $flags = array();
        foreach ($result as $row) {
            $flagId = $row['flag_id'];
            $flag = $this->buildDomainObject($row);
            $flag->setproject($project);
            $flags[$flagId] = $flag;
        }
        return $flags;*/
    }
    public function findAllByUser($userId) {
        $user = $this->userDAO->find($userId);
        $sql = "select * from t_flag where usr_id=? order by flag_id";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($userId));
        $result = $query->fetchAll();

        $flags = array();
        foreach ($result as $row) {
            $flagId = $row['flag_id'];
            $flag = $this->buildDomainObject($row);
            $flag->setUser($user);
            $flags[$flagId] = $flag;
        }
        return $flags;
    }
    public function findAllByComment($commentId) {
        //$comment = $this->commentDAO->find($commentId);
        $sql = "select * from t_flag where com_xid=? order by flag_id";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($commentId));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row)
            return $this->buildDomainObject($row);
        else
            return null;
        /*$result = $query->fetchAll();

        $flags = array();
        foreach ($result as $row) {
            $flagId = $row['flag_id'];
            $flag = $this->buildDomainObject($row);
            $flag->setComment($comment);
            $flags[$flagId] = $flag;
        }
        return $flags;*/
    }

    protected function buildDomainObject($row) {
        $flag = new Flag();
        $flag->setId($row['flag_id']);
        $flag->setAmount($row['flag_amount']);

        if (array_key_exists('proj_xid', $row) && $row["proj_xid"] !== null) {
            $projectId = $row['proj_xid'];
            $userId = $row['usr_xid'];
            $project = $this->projectDAO->find($projectId);
            $flag->setProject($project);
            $user = $this->userDAO->find($userId);
            $flag->setUser($user);

        }
        if (array_key_exists('com_xid', $row)) {
            $comId = $row['com_xid'];
            $userId = $row['usr_xid'];
            $comment = $this->commentDAO->find($comId);
            $flag->setComment($comment);
            $user = $this->userDAO->find($userId);
            $flag->setUser($user);
        }

        return $flag;
    }

    public function save($flag) {
        if($flag->getProject() !== null)
            $flagData = array(
                'flag_amount' => $flag->getAmount(),
                'proj_xid' => $flag->getProject()->getId(),
                'com_xid' => null,
                'usr_xid' => $flag->getUser()->getId()
                );
        else
            $flagData = array(
                'flag_amount' => $flag->getAmount(),
                'proj_xid' => null,
                'com_xid' => $flag->getComment()->getId(),
                'usr_xid' => $flag->getUser()->getId()
                );

        if ($flag->getId()) {
            $flagData["flag_id"] = $flag->getId();
            $sql = "update t_flag set flag_amount = :flag_amount, proj_xid = :proj_xid, com_xid = :com_xid ,usr_xid = :usr_xid where flag_id = :flag_id";
            $query = $this->getDb()->prepare($sql);
            $query->execute($flagData);
        } else {
            $sql = "insert into t_flag (flag_amount, proj_xid, com_xid, usr_xid) values (:flag_amount, :proj_xid, :com_xid, :usr_xid)";
            $query = $this->getDb()->prepare($sql);
            $query->execute($flagData);
            $flag->setId($this->getDb()->lastInsertId());
        }
    }
}
