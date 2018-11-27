<?php
    require_once("controller/authentification.php");
     
    function startRoutingAuthentification($routingArray){
        switch($routingArray[1])
        {
            case "connexion":
                if(authentication_login($_POST)){

                        header('Content-Type: application/json');
                        echo json_encode("success");
                        exit;
              

                }
                else{
                    header('Content-Type: application/json');
                    echo json_encode("failure");
                    exit;
                }
                break;
            case "enregistrement":
                //var_dump($_POST);
                //var_dump($_FILES);
                if(authentication_register($_POST,$_FILES)){
                    header('Content-Type: application/json');
                    echo json_encode("success");
                    exit;
                }
                else{
                    header('Content-Type: application/json');
                     if(isset($_SESSION["error_register_username"]))
                    {
                        //$returnVal = array('error_register_username', $_SESSION["error_register_username"]);
                        echo json_encode($_SESSION["error_register_username"]);
                        unset($_SESSION["error_register_username"]);
                    }
                    else if(isset($_SESSION["error_register_email"]))
                    {
                         //$returnVal = array('error_register_email', $_SESSION["error_register_email"]);
                        echo json_encode($_SESSION["error_register_email"]);
                        unset($_SESSION["error_register_email"]);
                    }
                    else {
                         echo json_encode("failure");
                    }
                    exit;
                }
                break;
            case "deconnexion":
                authentication_logout();
                header('Content-Type: application/json');
                echo json_encode("success");
                exit;
                break;
            default:
                http_response_code(404);
                $template = "404.phtml";
                require("views/layout.phtml");
                break;
        }
    }
?>
