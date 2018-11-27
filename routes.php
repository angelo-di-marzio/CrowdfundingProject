<?php
    require_once ("routes/admin.php");
    require_once ("routes/authentification.php");
    require_once ("routes/api.php");
    require_once ("routes/funded.php");
    require_once ("routes/idea.php");
    require_once ("routes/index.php");
    require_once ("routes/moderation.php");
    require_once ("routes/profile.php");
    require_once ("routes/project.php");
    require_once ("routes/view.php");
    require_once ("routes/create.php");
    require_once ("routes/edit.php");
    require_once ("routes/history.php");

    function startRouting($routingArray){

            /*sca évite le lancement des pages si on change l'url, peut quand même se déconnecter*/
            if($routingArray[0] != "authentification" && $routingArray[0] != "charte")
                if(isset($_SESSION["user"]) && !$_SESSION["user"]->getActive())
                {
                    startRoutingIndex("accueil");

                    return;
                }

            switch($routingArray[0])
            {
                case "":
                    header('Location: /accueil');
                    break;
                case "vue":
                    startRoutingView($routingArray);
                    break;
                case "admin":
                    if(isset($_SESSION["user"]) && $_SESSION["user"]->getRole() == "ROLE_ADMIN")
                        startRoutingAdmin($routingArray);
                    else
                        header('Location: /erreur');
                    break;
                case "moderation":
                    if(isset($_SESSION["user"]) && ($_SESSION["user"]->getRole() == "ROLE_ADMIN" || $_SESSION["user"]->getRole() == "ROLE_MODO"))
                        startRoutingModeration($routingArray);
                    else
                        header('Location: /erreur');
                    break;
                case "accueil":
                    startRoutingIndex($routingArray);
                    break;
                case "projet":
                    startRoutingProject($routingArray);
                    break;
                 case "mes_projet": //
                 if(isset($_SESSION["user"]))
                    startRoutingMyProject($routingArray);
                 else
                     header('Location: /erreur');
                    break;
                case "idee":
                    startRoutingIdea($routingArray);
                    break;
                case "finance":
                    startRoutingFunded($routingArray);
                    break;
                case "creer":
                    if(isset($_SESSION["user"]))
                        startRoutingCreate($routingArray);
                    else
                        header('Location: /erreur');
                    break;
                case "edition":
                    if(isset($_SESSION["user"]))
                        startRoutingEdit($routingArray);
                    else
                        header('Location: /erreur');
                    break;
                case "api":
                    if(isset($_SESSION["user"]))
                        startRoutingApi($routingArray);
                    else
                        header('Location: /erreur');
                    break;
                case "profil":
                    if(isset($_SESSION["user"]))
                        startRoutingProfile($routingArray);
                    else
                        header('Location: /erreur');
                    break;
                 case "password":
                    if(isset($_SESSION["user"]))
                        startRoutingProfile($routingArray);
                    else
                        header('Location: /erreur');
                    break;
                case "erreur":
                        $template = "404.phtml";
                        $title = "CrowdFunding Error";
                        require("views/layout.phtml");
                    break;
                case "authentification":
                    startRoutingAuthentification($routingArray);
                    break;
                case "historique":
                    if(isset($_SESSION["user"]))
                        startRoutingHistory($routingArray);
                    else
                        header('Location: /erreur');
                    break;
                case "charte":
                    $template = "rules.phtml";
                    $title = "CrowdFunding charte";
                    require("views/layout.phtml");
                    break;
                default:
                    http_response_code(404);
                    $template = "404.phtml";
                    $title = "CrowdFunding 404";
                    require("views/layout.phtml");
                    break;
            }

    }
?>
