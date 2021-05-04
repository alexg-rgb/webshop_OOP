<?php
//ON définie constante contenant le dossier racine du projet

use App\Autoloader;
use App\Core\Main;

define('ROOT', dirname(__DIR__));

// We import the autoloader
require_once ROOT.'/Autoloader.php';
Autoloader::register();

//Instance de main(routeur)
$app = new Main();

// On démarre l'app
$app->start();