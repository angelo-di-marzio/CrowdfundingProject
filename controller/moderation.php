<?php

    function controllerModerationProject(){
        return $GLOBALS["flagDAO"]->findAllProject();
    }

    function controllerModerationProjectApprove($post){
        $reportId = $post["report_id"];
        $report = $GLOBALS["flagDAO"]->find($reportId);
        if(!$report)
            return false;

        $projectId = $report->getProject()->getId();

        $GLOBALS["starDAO"]->deleteAllByProject($reportId);
        //TODO: We could have a problem here if comments are reported.
        $GLOBALS["flagDAO"]->deleteCommentsRelatedToProject($projectId);
        $GLOBALS["commentDAO"]->deleteAllByProject($projectId);
        $GLOBALS["likeDAO"]->deleteAllByProject($projectId);
        $GLOBALS["fileDAO"]->deleteAllByProject($projectId);
        $GLOBALS["flagDAO"]->delete($reportId);
        $GLOBALS["projectDAO"]->delete($projectId);
        return true;
    }

    function controllerModerationProjectDisapprove($post){
        $reportId = $post["report_id"];
        $GLOBALS["flagDAO"]->delete($reportId);
        return true;
    }

    function controllerModerationComment(){
        return $GLOBALS["flagDAO"]->findAllComment();
    }

    function controllerModerationCommentApprove($post){
        $reportId = $post["report_id"];
        $report = $GLOBALS["flagDAO"]->find($reportId);
        if(!$report)
            return false;

        $commentId = $report->getComment()->getId();
        $GLOBALS["flagDAO"]->delete($reportId);
        $GLOBALS["commentDAO"]->delete($commentId);
        return true;
    }

    function controllerModerationCommentDisapprove($post){
        $reportId = $post["report_id"];
        $GLOBALS["flagDAO"]->delete($reportId);
        return true;
    }

    function controllerModerationUtilisateurBlocage($post){
        $reportId = $post["report_id"];
        $report = $GLOBALS["flagDAO"]->find($reportId);
        if(!$report)
            return false;

        if($report->getComment())
            $userId = $report->getComment()->getUser()->getId();
        else
            $userId = $report->getProject()->getUser()->getId();

        $user = $GLOBALS["userDAO"]->find($userId);
        if(!$user)
            return false;

        if($report->getComment()){
          if(!controllerModerationCommentApprove($post))
              return false;
        }
        else{
          if(!controllerModerationProjectApprove($post))
              return false;
        }


        $projects = $GLOBALS["projectDAO"]->findAllByUser($user->getId());
        foreach($projects as $project){
            if($project->getType() != "funded"){
                $project->setType("cancelled");
                $GLOBALS["projectDAO"]->save($project);
            }
        }

        $user->setActive(0);
        $GLOBALS["userDAO"]->save($user);
        return true;
    }

?>
