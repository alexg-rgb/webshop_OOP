<?php
namespace App\Controllers;

abstract class Controller
{
    public function render(string $fichier, array $donnees = [], string $template = 'default')
    {
        //On extrait le contenu de $donnees
        extract($donnees);

        //On démarre le buffer de sortie
        ob_start();
        //From that point all outputs is stored

        //On crée le chemin vers la vue
        require_once ROOT.'/Views/'.$fichier.'.php';

        $content = ob_get_clean();

        require_once ROOT.'/Views/'.$template.'.php';
    }
}