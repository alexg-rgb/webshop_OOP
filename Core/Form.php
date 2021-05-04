<?php

namespace App\core;

class Form
{
    private $formCode= '';


    /**
     * Génére le form html
     *
     * @return void
     */
    public function create()
    {
        return $this->formCode;
    }

    /**
     * Valide si tout les champs proposés sont remplis
     *
     * @param array $form Tableau issu du form ($_POST , $_GET)
     * @param array $champs Tableau listant les champs obligatoire
     * @return bool
     */
    //si plus de verif utiliser regex
    public static function validate(array $form, array $champs)
    {
        //On parcours les champs
        // | shift alt L
        foreach($champs as $champ){
            //Si le champ est absent ou vide dans le form
            if(!isset($form[$champ]) || empty($form[$champ])){
                // On sort en retournant false
                return false;
            }
        }
        return true;
    }
    /**
     * Ajoute les att à la balise
     *
     * @param array $attributs tableau associaatif
     * @return string chaine de caract générée
     */
    private function ajoutAttributs(array $attributs): string
    {
        //On initialise une string
        $string = '';

        //On liste les attributs "courts"
        $court = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'formnovalidate'];

        //ON boucle sur le tableau d'atrr
        foreach($attributs as $attribut => $valeur){
            //Is it a short attribute ?
            if(in_array($attribut, $court) && $valeur == true){
                $string.= " $attribut";
            }else{
                //On ajoute l'attr='valeur'
                $string .= " $attribut='$valeur'";
            }
        }

        return $string;
    }

    /**
     * Balise d'ouverture du fomrulaisr
     *
     * @param string $method Method du fomr post ou get
     * @param string $action action du form
     * @param array $attributs atribut
     * @return self
     */
    public function debutForm(string $method ='post', string $action ='#', array $attributs= []): self
    {
        //ON créée la balise form
        $this->formCode .= "<form action ='$action' method='$method'";

        //On ajoute les attrs evntuels
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';

        return $this;
    }


    /**
     * Balise de fermture du formulaire
     *
     * @return self
     */
    public function finForm(): self
    {
        $this->formCode .= '</form>';
        return $this;
    }


    /**
     * Ajout d'un label
     *
     * @param string $for
     * @param string $texte
     * @param array $attributs
     * @return self
     */
    public function ajoutLabelFor(string $for, string $texte, array $attributs = []): self
    {
        //On ouvre la balise
        $this->formCode .= "<label for ='$for'";

        //Ajouts attr
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';

        //On ajoute le texte
        $this->formCode .= ">$texte</label>";

        return $this;
    }

    public function ajoutInput(string $type, string $name, array $attributs =[]): self
    {
        //On ouvre la balise
        $this->formCode .= "<input type='$type' name='$name'";

        //On ajoute les attriburs
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';

        return $this;
    }

    public function ajoutTextarea(string $name, string $value = '', array $attributs = []): self
    {
        //On ouvre la balise
        $this->formCode .= "<textarea name ='$name'";

        //Ajouts attr
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';

        //On ajoute le texte
        $this->formCode .= ">$value</textarea>";

        return $this;
    }

    public function ajoutSelect(string $name, array $options, array $attributs =[]): self
    {
        //On créée le select
        $this->formCode .= "<select name='$name'";

        //On ajoute les attributs
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';

        //On ajoute les options
        foreach($options as $valeur => $texte){
            $this->formCode .= "<option value='$valeur'>$texte</option>";
        }

        //On ferme le select
        $this->formCode .= '</select>';

        return $this;
    }

    public function ajoutButton(string $text, array $attributs = []): self
    {
        //Open button
        $this->formCode .= '<button ';
        //Add atributes
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';
        //Add tex and close button
        $this->formCode .= ">$text</button>";

        return $this;
    }
}