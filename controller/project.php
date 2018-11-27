<?php

    function controlerProjectAllList(){
        return $GLOBALS["projectDAO"]->findAll();
    }

    // sca top 6 project
    function controlerProjectTopSixList(){
        return $GLOBALS["projectDAO"]->findTopSix();
    }

    function controlerProjectAllCategoryList($categoryName){
        $category = $GLOBALS["categoryDAO"]->findByName($categoryName);
        if (!$category)
            return array();

        return $GLOBALS["projectDAO"]->findAllByCat($category->getId());
    }

    function controlerProjectIdeaList(){
        return $GLOBALS["projectDAO"]->findAllByType("idea");
    }

    function controlerProjectProjectList(){
        return $GLOBALS["projectDAO"]->findAllByType("project");
    }

    // sca: controller qui va rechercher les projets par mots clés
   function controlerProjectFoundByKeyword($keyword){

        return $GLOBALS["projectDAO"]->findAllByKeyword($keyword);
    }

    // sca: controller qui va rechercher les projets par user
    function controlerProjectFoundByUser($userId){

        return $GLOBALS["projectDAO"]->findAllByUser($userId);
    }

    function controlerProjectFundedList(){
        return $GLOBALS["projectDAO"]->findAllByType("funded");
    }

    function controlerProjectIdeaCategoryList($categoryName){
        $category = $GLOBALS["categoryDAO"]->findByName($categoryName);
        if (!$category)
            return array();
        return $GLOBALS["projectDAO"]->findAllByTypeAndCat("idea", $category->getId());
    }

    function controlerProjectProjectCategoryList($categoryName){
        $category = $GLOBALS["categoryDAO"]->findByName($categoryName);
        if (!$category)
            return array();
        return $GLOBALS["projectDAO"]->findAllByTypeAndCat("project", $category->getId());
    }

    //sca gestion des catégories pour mes projets
    function controlerProjectOwnProjectCategoryList($categoryName,$userId){
        $category = $GLOBALS["categoryDAO"]->findByName($categoryName);
        if (!$category)
            return array();

        return $GLOBALS["projectDAO"]->findOwnAllProjectByCat($category->getId(),$userId);
    }

    function controlerProjectFundedCategoryList($categoryName){
        $category = $GLOBALS["categoryDAO"]->findByName($categoryName);
        if (!$category)
            return array();
        return $GLOBALS["projectDAO"]->findAllByTypeAndCat("funded", $category->getId());
    }

    function controllerProjectCreate($post, $files){
        $project = new Project();
        $project->setTitle($post["title"]);
        $project->setContent($post["description"]);
        $project->setCategory($GLOBALS["categoryDAO"]->find($post["category"]));
        $project->setUser($_SESSION["user"]);
        $project->setDate(date("Y-m-d H:i:s"));
        $project->setEnddate(date("Y-m-d H:i:s"));
        $project->setMaxstars($post["stars_total"]);
        $project->setType("idea");

        $GLOBALS["projectDAO"]->save($project);

        foreach ($files as $filePost){
            if($filePost["type"] === "image/png" || $filePost["type"] === "image/jpeg")
            {
                $file = new File();

                $filename = uniqid();
                if($filePost["type"] === "image/png")
                    $filename = $filename.".png";
                else
                    $filename = $filename.".jpg";

                move_uploaded_file($filePost["tmp_name"], "img/".$filename);
                $file->setUrl($filename);
                $file->setProject($project);
                $GLOBALS["fileDAO"]->save($file);
            }
        }
        return $project->getId();
    }

    function controllerProjectEdit($post, $files){
        $project = $GLOBALS["projectDAO"]->find($post["id"]);
        $project->setTitle($post["title"]);
        $project->setContent($post["description"]);
        $project->setCategory($GLOBALS["categoryDAO"]->find($post["category"]));
        $project->setMaxstars($post["stars_total"]);

        $GLOBALS["projectDAO"]->save($project);

        $i = 0;
        $filesStored = $GLOBALS["fileDAO"]->findAllByProject($project->getId());

        foreach ($files as $filePost){
            if($filePost["type"] === "image/png" || $filePost["type"] === "image/jpeg")
            {
                $filename = uniqid();
                if($filePost["type"] === "image/png")
                    $filename = $filename.".png";
                else
                    $filename = $filename.".jpg";

                if(count($filesStored) > $i)
                {
                    $file = $filesStored[$i];
                }
                else
                {
                    $file = new File();
                }

                move_uploaded_file($filePost["tmp_name"], "img/".$filename);
                $file->setUrl($filename);
                $file->setProject($project);
                $GLOBALS["fileDAO"]->save($file);
            }
            $i++;
        }
        return $project->getId();
    }


?>
