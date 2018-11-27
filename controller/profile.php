<?php

    function controllerProfileEditPassword($post){
        $username = $post["username"];

        $password = $post["password"];

        $user = $GLOBALS["userDAO"]->loadUserByUsername($username);

        if(!$user || $user->getId() == $_SESSION["user"]->getId()){
            $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
    		$password = hash('sha512', $password . $random_salt);
           
           // $_SESSION["user"]->setUsername($username);
           
            $_SESSION["user"]->setPassword($password);
            $_SESSION["user"]->setSalt($random_salt); 

            $GLOBALS["userDAO"]->save($_SESSION["user"]);

            $user_browser = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
            return true;
        }
        return false;
    }

    function controllerProfileEdit($post,$files){

       // var_dump($post);
        $username = $post["username"];
        $user = $GLOBALS["userDAO"]->loadUserByUsername($username);
        if(!$user || $user->getId() == $_SESSION["user"]->getId()){
            
            $_SESSION["user"]->setLastname($post["lastname"]);
            $_SESSION["user"]->setFirstname($post["firstname"]);
            $_SESSION["user"]->setEmail($post["email"]);

             if($files['new_avatar']['size'] != 0)
            {
                $id = uniqid();
                $content_dir = 'img/'; // dossier où sera déplacé le fichier
                $tmp_file = $files['new_avatar']['tmp_name'];
           
                // on vérifie maintenant l'extension
                $type_file = $files['new_avatar']['type'];

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
                $_SESSION["user"]->setAvatar($content_dir.$id);

            }

            $GLOBALS["userDAO"]->save($_SESSION["user"]);

            //var_dump($_SESSION["user"]);
            //$user_browser = $_SERVER['HTTP_USER_AGENT'];
            //$_SESSION['login_string'] = hash('sha512', $_SESSION["user"]->getPassword() . $user_browser);
            return true;
        }
        return false;
    }

?>
