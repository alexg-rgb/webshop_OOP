<?php
namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;

class UsersController extends Controller
{
    /**
     * Connexion des users
     *
     * @return void
     */
    public function login()
    {
        
        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor('email', 'E-mail :')
            ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email'])
            ->ajoutLabelFor('pass', 'Password :')
            ->ajoutInput('password', 'password', ['id' => 'pass','class' => 'form-control'])
            ->ajoutButton('Connect', ['class' => 'btn btn-primary'])
            ->finForm();
         
        $this->render('users/login', ['loginForm' => $form->create()]);
    }

    /**
     * Inscription des users
     *
     * @return void
     */
    public function register()
    {
        //On vérifie si le form est valide
        if(Form::validate($_POST, ['email', 'password'])){
            // Le formulaire est valide
            //On nettoie le mail
            $email = strip_tags($_POST['email']);

            //On chiffre le password
            $pass = password_hash($_POST['password'], PASSWORD_ARGON2I);

            //ON hydrate l'user 
            $user = new UsersModel;

            $user->setEmail($email)
                ->setPassword($pass)
            ;
            //ON stocke l'user dans la db
            $user->create();
        }
        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor('email', 'E-mail :')
            ->ajoutInput('email', 'email', ['id' => 'email', 'class' => 'form-control'])
            ->ajoutLabelFor('password', 'Password :')
            ->ajoutInput('password', 'password', ['id' => 'pass', 'class' => 'form-control'])
            ->ajoutButton('M\'inscrire', ['class' => 'btn btn-primary'])
            ->finForm();

            $this->render('users/register', ['registerForm' => $form->create()]);
    }
}