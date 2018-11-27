<?php

    function controllerSendStar($post){
        $projectId = $post["project_id"];
        $amount = $post["amount"];
        if($amount <= 0)
            return false;
            
        $project = $GLOBALS["projectDAO"]->find($projectId);

        if(!$project)
            return false;

        $star = new Star();
        $star->setUser($_SESSION["user"]);
        $star->setProject($project);
        $star->setAmount($amount);

        $GLOBALS["starDAO"]->save($star);

        $stars = $GLOBALS["starDAO"]->findAllByProject($projectId);
        $total = 0;
        foreach($stars as $star){
            $total += $star->getAmount();
        }
        if($total >= $project->getMaxstars()){
            $project->setType("funded");
            $GLOBALS["projectDAO"]->save($project);
        }

        return true;
    }

?>
