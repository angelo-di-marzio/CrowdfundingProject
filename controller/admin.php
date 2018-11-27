<?php
    function controlerAdminCategories(){
        return $GLOBALS["categoryDAO"]->findAll();
    }

    function controlerAdminAddCategory($post){
        $category = new Category();
        $category->setName($post["name"]);
        $GLOBALS["categoryDAO"]->save($category);
        return true;
    }

    function controlerAdminEditCategory($post){
        $category = $GLOBALS["categoryDAO"]->find($post["id"]);
        if($category)
        {
            $category->setName($post["name"]);
            $GLOBALS["categoryDAO"]->save($category);
            return true;
        }
        return false;
    }

    function controlerAdminDeleteCategory($post){
        $GLOBALS["categoryDAO"]->delete($post["id"]);
        return true;
    }

    function controlerAdminRoles(){
        return $GLOBALS["userDAO"]->findAll();
    }

    function controlerAdminAddRole($post){
        $user = $GLOBALS["userDAO"]->loadUserByUsername($post["username"]);
        if(!$user)
            return false;

        $user->setRole($post["role"]);
        $GLOBALS["userDAO"]->save($user);
        return true;
    }

    function controlerAdminEditRole($post){
        $user = $GLOBALS["userDAO"]->loadUserByUsername($post["username"]);
        if(!$user)
            return false;

        $user->setRole($post["role"]);
        $GLOBALS["userDAO"]->save($user);
        return true;
    }

    function controlerAdminRemoveRole($post){
        $user = $GLOBALS["userDAO"]->loadUserByUsername($post["username"]);
        if(!$user)
            return false;

        $user->setRole("ROLE_USER");
        $GLOBALS["userDAO"]->save($user);
        return true;
    }


?>
