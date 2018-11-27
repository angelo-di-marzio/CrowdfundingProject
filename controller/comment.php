<?php
    function controllerCommentAdd($post){
        $projectId = $post["project_id"];
        $commentText = $post["comment"];
        $project = $GLOBALS["projectDAO"]->find($projectId);
        $comment = new Comment();
        $comment->setProject($project);
        $comment->setUser($_SESSION["user"]);
        $comment->setContent($commentText);
        $comment->setDate(date("Y-m-d H:i:s"));
        $GLOBALS["commentDAO"]->save($comment);
        return true;
    }

    function controllerCommentRemove($commentId){

        $GLOBALS["commentDAO"]->delete($commentId);

        return true;
    }

?>
