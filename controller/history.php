<?php
    function controllerHistoryStars(){
        return $GLOBALS["starDAO"]->findAllByUser($_SESSION["user"]->getId());
    }

?>
