<?php
class FileDAO extends DAO
{
    private $projectDAO;

    public function find($id) {

        $sql = "select * from t_files where file_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row)
            return $this->buildDomainObject($row);
        else
            return null;

    }

    public function delete($id) {
        $sql = "delete from t_files where file_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
    }

    public function deleteAllByProject($projectId) {
        $sql = "delete from t_files where proj_xid=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($projectId));
    }


    public function setProjectDAO($projectDAO) {
        $this->projectDAO = $projectDAO;
    }


    public function findAll() {
        $sql = "select * from t_files order by file_id desc";
        $query = $this->getDb()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        $entities = array();
        foreach ($result as $row) {
            $id = $row['file_id'];
            arrau_push($entities, $this->buildDomainObject($row));
        }
        return $entities;
    }

    public function findAllByProject($projectId) {
        //$project = $this->projectDAO->find($projectId);
        $sql = "select * from t_files where proj_xid=? order by file_id";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($projectId));
        $result = $query->fetchAll();

        $files = array();
        foreach ($result as $row) {
            $projId = $row['proj_xid'];
            $file = $this->buildDomainObject($row);
            //$file->setProject($project);
            array_push($files, $file);
        }
        return $files;
    }

    protected function buildDomainObject($row) {
        $file = new File();
        $file->setId($row['file_id']);
        $file->setUrl($row['file_proj_picurl']);

        if (array_key_exists('proj_xid', $row)) {
            // Find and set the associated project
            $projectId = $row['proj_xid'];
            //$project = $this->projectDAO->find($projectId);
            //$file->setProject($project);
        }
        return $file;
    }

    public function save($file) {
        $fileData = array(
            'proj_xid' => $file->getProject()->getId(),
            'file_proj_picurl' => $file->getUrl()
            );

        if ($file->getId()) {
            $fileData["file_id"] = $file->getId();
            $sql = "update t_files set proj_xid = :proj_xid, file_proj_picurl = :file_proj_picurl where file_id = :file_id";
            $query = $this->getDb()->prepare($sql);
            $query->execute($fileData);
        } else {
            $sql = "insert into t_files (proj_xid, file_proj_picurl) values (:proj_xid, :file_proj_picurl)";
            $query = $this->getDb()->prepare($sql);
            $query->execute($fileData);
            $file->setId($this->getDb()->lastInsertId());
        }
    }

}
