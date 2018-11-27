<?php
class CategoryDAO extends DAO
{


    public function find($id) {
        $sql = "select * from t_categories where cat_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row)
            return $this->buildDomainObject($row);
        else
            return null;
    }

    public function findByName($name) {
        $sql = "select * from t_categories where cat_name=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($name));
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row)
            return $this->buildDomainObject($row);
        else
            return null;
    }

    public function delete($id) {
        $sql = "delete from t_categories where cat_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
    }

    public function findAll() {
        $sql = "select * from t_categories order by cat_id desc";
        $query = $this->getDb()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        $entities = array();
        foreach ($result as $row) {
            $id = $row['cat_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    protected function buildDomainObject($row) {
        $cat = new Category();
        $cat->setId($row['cat_id']);
        $cat->setName($row['cat_name']);

        return $cat;
    }

    public function save(Category $cat) {
        $catData = array(
            'cat_name' => $cat->getName()
            );

        if ($cat->getId()) {
            $catData["cat_id"] = $cat->getId();
            $sql = "update t_categories set cat_name = :cat_name where cat_id = :cat_id";
            $query = $this->getDb()->prepare($sql);
            $query->execute($catData);
        } else {
            $sql = "insert into t_categories (cat_name) values (:cat_name)";
            $query = $this->getDb()->prepare($sql);
            $query->execute($catData);
            $cat->setId($this->getDb()->lastInsertId());
        }
    }

}
