<?php
    function authentication_check(){
		if(isset($_SESSION['user']) && isset($_SESSION['login_string']))
		{
			$user_id = $_SESSION['user']->getId();
			$login_string = $_SESSION['login_string'];
			$user_browser = $_SERVER['HTTP_USER_AGENT'];

            $user = $GLOBALS["userDAO"]->find($user_id);

            if ($user){
                $password = $user->getPassword();
                $login_check = hash('sha512', $password . $user_browser);
                if($login_check != $login_string){
                    unset($_SESSION['user']);
        			      unset($_SESSION['login_string']);
                }
                else{
                    $_SESSION['user'] = $GLOBALS["userDAO"]->refreshUser($_SESSION['user']);
                }
            }
            else{
                unset($_SESSION['user']);
    			      unset($_SESSION['login_string']);
            }
		}
		else
		{
			unset($_SESSION['user']);
			unset($_SESSION['login_string']);
		}
    }

    function authentication_login($post){
        $username = $post["username"];
        $password = $post["password"];

        $user = $GLOBALS["userDAO"]->loadUserByUsername($username);

        if($user)
        {
            $dbPassword = $user->getPassword();
            $dbSalt = $user->getSalt();
            $password = hash('sha512', $password . $dbSalt);

            if($dbPassword == $password)
            {
                $user_browser = $_SERVER['HTTP_USER_AGENT'];
                $_SESSION['user'] = $user;
                $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                return true;
            }
        }
        return false;
    }

    function authentication_register($post,$files){
        $username = $post["username"];
        $password = $post["password"];
        $lastname = $post["lastname"];
        $firstname = $post["firstname"];
        $email = $post["email"];

        $role = "ROLE_USER";

        $user = $GLOBALS["userDAO"]->loadUserByUsername($username);
        $user2 = $GLOBALS["userDAO"]->loadUserByEmail($email);


        if($user != null)
        {
            $_SESSION["error_register_username"] = "Ce nom d'utilisateur existe déjà, veuillez en choisir un autre.";
        }

        if($user2 != null)
        {
            $_SESSION["error_register_email"] = "Ce mail existe déjà, veuillez en choisir un autre.";
        }


        if($user == null && $user2 == null){
            $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
    		$password = hash('sha512', $password . $random_salt);

            $user = new User();
            $user->setRole($role);
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setLastname($lastname);
            $user->setFirstname($firstname);
            $user->setEmail($email);
            $user->setSalt($random_salt);

            //echo 'ok1';
            if($files['avatar']['size'] != 0)
            {
                $id = uniqid();
                $content_dir = 'img/'; // dossier où sera déplacé le fichier
                $tmp_file = $files['avatar']['tmp_name'];

                // on vérifie maintenant l'extension
                $type_file = $files['avatar']['type'];

                if( !strstr($type_file, 'jpg')
                    && !strstr($type_file, 'jpeg')
                    && !strstr($type_file, 'bmp')
                    && !strstr($type_file, 'gif')
                    && !strstr($type_file, 'png') )
                {
                    return false;
                }

                if( !move_uploaded_file($tmp_file, $content_dir.$id) )
                {
                    return false;
                }
                $user->setAvatar($content_dir.$id);

            }
            else
            {
                $user->setAvatar('img/profil-standard.png');
            }

            //echo 'ok3';
            //return false;     test $files
            $GLOBALS["userDAO"]->save($user);

            $user_browser = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION['user'] = $user;

            $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
            return true;
        }
        else
        {
          
          return false;
        }
    }

    function authentication_logout(){
        if(isset($_SESSION['user'], $_SESSION['login_string']))
		{
            unset($_SESSION['user']);
			unset($_SESSION['login_string']);
        }
    }
?>
