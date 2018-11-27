<?php

    function controllerLikeAdd($post){
        $projectId = $post["project_id"];
        $userId = $_SESSION["user"]->getId();


        if($GLOBALS["likeDAO"]->findByProjectAndUser($projectId, $userId))
            return false;
        $project = $GLOBALS["projectDAO"]->find($projectId);
        if($userId == $project->getUser()->getId())
            return false;

        $like = new Like();
        $like->setUser($_SESSION["user"]);
        $like->setProject($project);
        $GLOBALS["likeDAO"]->save($like);

        //sca changement 1000 par maxstar
        //REVERT: if(count($GLOBALS["likeDAO"]->findAllByProject($projectId)) == $project->getMaxstars()){
        if(count($GLOBALS["likeDAO"]->findAllByProject($projectId)) >= 10){
            $project->setType("project");
            $GLOBALS["projectDAO"]->save($project);
            $GLOBALS["projectDAO"]->sendMailUpgradeProject($project->exportToHtml(),$project->getUser()->getEmail(),"Passage d'idée en projet");
       }

        return true;
    }



?>
