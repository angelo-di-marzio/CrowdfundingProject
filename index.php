<?php

    require_once("ENV/dev.php");

    try {
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
        exit;
    }

    require_once("domain/Category.php");
    require_once("domain/Comment.php");
    require_once("domain/File.php");
    require_once("domain/Flag.php");
    require_once("domain/Like.php");
    require_once("domain/Project.php");
    require_once("domain/Star.php");
    require_once("domain/User.php");

    require_once("dao/DAO.php");
    require_once("dao/CategoryDAO.php");
    $GLOBALS["categoryDAO"] = new CategoryDAO($dbh);
    require_once("dao/CommentDAO.php");
    $GLOBALS["commentDAO"] = new CommentDAO($dbh);
    require_once("dao/FileDAO.php");
    $GLOBALS["fileDAO"] = new FileDAO($dbh);
    require_once("dao/FlagDAO.php");
    $GLOBALS["flagDAO"] = new FlagDAO($dbh);
    require_once("dao/LikeDAO.php");
    $GLOBALS["likeDAO"] = new LikeDAO($dbh);
    require_once("dao/StarDAO.php");
    $GLOBALS["starDAO"] = new StarDAO($dbh);
    require_once("dao/UserDAO.php");
    $GLOBALS["userDAO"] = new UserDAO($dbh);
    require_once("dao/ProjectDAO.php");
    $GLOBALS["projectDAO"] = new ProjectDAO($dbh);

    $GLOBALS["projectDAO"]->setUserDAO($GLOBALS["userDAO"]);
    $GLOBALS["projectDAO"]->setCatDAO($GLOBALS["categoryDAO"]);
    $GLOBALS["projectDAO"]->setFileDAO($GLOBALS["fileDAO"]);
    $GLOBALS["projectDAO"]->setCommentDAO($GLOBALS["commentDAO"]);
    $GLOBALS["projectDAO"]->setStarDAO($GLOBALS["starDAO"]);
    $GLOBALS["projectDAO"]->setLikesDAO($GLOBALS["likeDAO"]);

    $GLOBALS["fileDAO"]->setProjectDAO($GLOBALS["projectDAO"]);

    $GLOBALS["commentDAO"]->setProjectDAO($GLOBALS["projectDAO"]);
    $GLOBALS["commentDAO"]->setUserDAO($GLOBALS["userDAO"]);

    $GLOBALS["starDAO"]->setUserDAO($GLOBALS["userDAO"]);

    $GLOBALS["flagDAO"]->setCommentDAO($GLOBALS["commentDAO"]);
    $GLOBALS["flagDAO"]->setUserDAO($GLOBALS["userDAO"]);
    $GLOBALS["flagDAO"]->setProjectDAO($GLOBALS["projectDAO"]);

    require_once("controller/authentification.php");

    require_once("routes.php");
    session_start();
    authentication_check();

    startRouting(getSplashedUrl());

    function getSplashedUrl()
	{
		$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
		$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
		if(strstr($uri, '?'))
			$uri = substr($uri, 0, strpos($uri, '?'));
		$uri = '/' . trim($uri, '/');
		if($uri == '/')
			$uri = '/accueil';
		$routes = array();
		$finalroutes = array();
		$routes = explode('/', $uri);
		foreach($routes as $route)
			if(trim($route) != '')
				array_push($finalroutes, $route);
		return $finalroutes;
	}
?>
