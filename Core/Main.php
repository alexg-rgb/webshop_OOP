<?php
namespace App\Core;

use App\Controllers\MainController;


/**
 * Routeur principal
 */
class Main
{
    public function start()
    {
        //On démarre la session
        session_start();
        //ON retire le trailing slash eventuel de l'url
        //on récupere l'url
        $uri = $_SERVER['REQUEST_URI'];

        //on check si uri est pas vide et se termine par /
        if(!empty($uri) && $uri!='/' && $uri[-1] === "/"){
            //delete /
            $uri = substr($uri, 0, -1);

            //On envoie code de redirection permanente
            http_response_code(301);

            //OON redirige vers l'url sans /
            header('Location: '.$uri);
        }
        //On gère les paramètres de l'URL
        //p=controlleur/method/parametre
        //On sépare les paramètres dans un tableau
        $params = [];
        if(isset($_GET['p']))
            $params = explode('/', $_GET['p']); 


         //var_dump($params);
        if($params[0] != ''){
            //we have at least one param
            //ON récupère le nom du controller a instancier
            //On met une maj en 1ere lettre on ajoute le namespace avant et on ajoute "Controller après"
            $controller = '\\App\\Controllers\\'.ucfirst(array_shift($params)).'Controller';

            //On instancie le controleur
            $controller = new $controller();

            //On récupere le 2eme param d'url
            $action = (isset($params[0])) ? array_shift($params): 'index';

            //On verifie si la methode existe dans notre controller
            if(method_exists($controller, $action)){
                //si il reste des params on les passes à la méthode sous forme de tableau
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action($params);
            }else{
                http_response_code(404);
                echo "La page existe pas";
            }

        }else{
            //On a pas de paramètre
            //ON instancie le controleur par défaut
            $controller = new MainController;

            //On appelle la méthode index
            $controller->index(); 
        }
    } 
}