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
        //On check si le form est complet
        if(Form::validate($_POST, ['email', 'password'])){
            //Le form est complet
            //On va chercher dans la db l'user avec l'email entré
            $usersModel = new UsersModel;
            $userArray = $usersModel->findOneByEmail(strip_tags($_POST['email']));
            //Si user existe
            if(!$userArray){
                $_SESSION['erreur']= 'L\'adresse mail et/ou password est incorrect';
                header('Location: /users/login');
                exit;
            }
            //L'user existe
            $user = $usersModel->hydrate($userArray);
            //On vérifie si le mot de passe est ok
            if(password_verify($_POST['password'], $user->getPassword())){
                //Password ok
                //ON crée la session
                $user->setSession();
                header('Location: /');
                exit;
            }else{
                //Password incorect
                $_SESSION['erreur']= 'L\'adresse mail et/ou password est incorrect';
                header('Location: /users/login');
                exit;
            }
        }
        
        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor('email', 'E-mail :')
            ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email'])
            ->ajoutLabelFor('pass', 'Password :')
            ->ajoutInput('password', 'password', ['id' => 'pass','class' => 'form-control'])
            ->ajoutButton('Connect', ['class' => 'btn btn-primary mt-3 mb-1'])
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
            ->ajoutButton('M\'inscrire', ['class' => 'btn btn-primary mt-3 mb-1'])
            ->finForm();

            $this->render('users/register', ['registerForm' => $form->create()]);
    }

    /**
     * Logout the user
     *
     * @return exit
     */
    public function logout()
    {
        unset($_SESSION['user']);
        //HTTP refere when we logout we stay on the same page
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;
    }
}