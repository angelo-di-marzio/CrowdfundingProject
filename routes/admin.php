<?php
    require_once("controller/admin.php");

    function startRoutingAdmin($routingArray){
        switch($routingArray[1])
        {
            case "categories":
                $categories = controlerAdminCategories();
                $template = "admin_category.phtml";
                $title = "CrowdFunding Catégories";
                require("views/layout.phtml");
                break;
            case "categorie-ajout":
                if(controlerAdminAddCategory($_POST)){
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
            case "categorie-modification":
                if(controlerAdminEditCategory($_POST)){
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
            case "categorie-suppression":
                if(controlerAdminDeleteCategory($_POST)){
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
            case "roles":
                    $users = controlerAdminRoles();
                    $template = "admin_role.phtml";
                    $title = "CrowdFunding Roles";
                    require("views/layout.phtml");
                    break;
            case "roles-ajout":
                    if(controlerAdminAddRole($_POST)){
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
            case "roles-edition":
                    if(controlerAdminEditRole($_POST)){
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
            case "roles-suppression":
                    if(controlerAdminRemoveRole($_POST)){
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
            default:
                http_response_code(404);
                $template = "404.phtml";
                require("views/layout.phtml");
                break;
        }
    }

?>
