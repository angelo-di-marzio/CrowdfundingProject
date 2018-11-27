<?php

    function controllerCategoryAllList(){
        return $GLOBALS["categoryDAO"]->findAll();
    }

?>
