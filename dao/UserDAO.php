<?php
class UserDAO extends DAO
{
    public function save($user) {

         $userData= array(
            'usr_name' => $user->getUsername(),
            'usr_salt' => $user->getSalt(),
            'usr_password' => $user->getPassword(),
            'usr_role' => $user->getRole(),
            'usr_mail' => $user->getEmail(),
            'usr_avatarurl' => $user->getAvatar(),
            'usr_firstname' => $user->getFirstname(),
            'usr_lastname' => $user->getLastname()
            );


        if ($user->getId()) {

            $userData['usr_active'] = $user->getActive();
            $userData["usr_id"] = $user->getId();
            $sql = "update t_user
                    set usr_name = :usr_name,
                    usr_salt = :usr_salt,
                    usr_password = :usr_password,
                    usr_role = :usr_role,
                    usr_active = :usr_active,
                    usr_mail = :usr_mail,
                    usr_avatarurl = :usr_avatarurl,
                    usr_firstname = :usr_firstname,
                    usr_lastname = :usr_lastname
                    where usr_id = :usr_id";
            $query = $this->getDb()->prepare($sql);
            $query->execute($userData);
           // var_dump($user);
        } else {


            $sql = "insert into t_user
                    (usr_name,
                     usr_salt,
                     usr_password,
                     usr_role,
                     usr_active,
                     usr_mail,
                     usr_avatarurl,
                     usr_firstname,
                     usr_lastname
                     )
                    values
                    (:usr_name,
                     :usr_salt,
                     :usr_password,
                     :usr_role,
                      1,
                     :usr_mail,
                     :usr_avatarurl,
                     :usr_firstname,
                     :usr_lastname)";
            $query = $this->getDb()->prepare($sql);
            $query->execute($userData);
            $user->setId($this->getDb()->lastInsertId());
        }



    }

    public function delete($id) {
        $sql = "delete from t_user where usr_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
    }

    public function findAll() {
        $sql = "select * from t_user order by usr_role, usr_name";
        $query = $this->getDb()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        $entities = array();
        foreach ($result as $row) {
            $id = $row['usr_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    public function find($id) {
        $sql = "select * from t_user where usr_id=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($id));
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row)
            return $this->buildDomainObject($row);
        else
            return null;
    }

    public function loadUserByUsername($username)
    {
        $sql = "select * from t_user where usr_name=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($username));
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row)
            return $this->buildDomainObject($row);
        else
            return null;
    }

    public function loadUserByEmail($usermail)
    {
        $sql = "select * from t_user where usr_mail=?";
        $query = $this->getDb()->prepare($sql);
        $query->execute(array($usermail));
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row)
            return $this->buildDomainObject($row);
        else
            return null;
    }



    public function refreshUser($user)
    {
        return $this->find($user->getId());
    }

    protected function buildDomainObject($row) {

       // var_dump($row);
        $user = new User();
        $user->setId($row['usr_id']);
        $user->setUsername($row['usr_name']);
        $user->setPassword($row['usr_password']);
        $user->setLastname($row['usr_lastname']);
        $user->setFirstname($row['usr_firstname']);
        $user->setEmail($row['usr_mail']);
        $user->setAvatar($row['usr_avatarurl']);
        $user->setSalt($row['usr_salt']);
        $user->setRole($row['usr_role']);
        $user->setActive($row['usr_active']);
        $user->setBlocked($row['usr_blocked']);
       // var_dump($user);
        return $user;
    }
}
