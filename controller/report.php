<?php

    function controllerReportComment($id){
        $flag = $GLOBALS["flagDAO"]->findAllByComment($id);

        if(!$flag){
            $comment = $GLOBALS["commentDAO"]->find($id);
            $flag = new Flag();
            $flag->setComment($comment);
            $flag->setAmount(0);
        }
        $flag->setAmount($flag->getAmount()+1);
        // sca
        $flag->setUser($_SESSION["user"]);
        $GLOBALS["flagDAO"]->save($flag);
        return true;
    }

    function controllerReportProject($id){
        $flag = $GLOBALS["flagDAO"]->findAllByProject($id);

        if(!$flag){
            $project = $GLOBALS["projectDAO"]->find($id);
            $flag = new Flag();
            $flag->setProject($project);
            $flag->setAmount(0);
        }
        $flag->setAmount($flag->getAmount()+1);
        // sca
        $flag->setUser($_SESSION["user"]);
        $GLOBALS["flagDAO"]->save($flag);
        return true;
    }

?>
