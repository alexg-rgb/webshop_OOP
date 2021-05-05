<?php
namespace App\Controllers;
use App\Core\Form;
use App\Models\ContactModel;

class ContactController extends Controller
{
    public function contact()
    {
        if(Form::validate($_POST, ['name', 'email', 'subject', 'message'])){
            // Le formulaire est valide
            //On nettoie le mail
            $name = htmlspecialchars($_POST['name']);
            $email = strip_tags($_POST['email']);
            $subject = htmlspecialchars($_POST['subject']);
            $message = htmlspecialchars($_POST['message']);
            
            //ON hydrate l'user 
            $contact = new ContactModel;

            $contact->setName($name)
                ->setEmail($email)
                ->setSubject($subject)
                ->setMessage($message)
            ;
            //ON stocke l'user dans la db
            $contact->create();
        }

        $form = new Form;

        $form->debutForm()
            

            ->ajoutLabelFor('name', 'Name :')
            ->ajoutInput('text', 'name', ['id' => 'name', 'class' => 'form-control'])

            ->ajoutLabelFor('email', 'Email :')
            ->ajoutInput('email', 'email', ['id' => 'email', 'class' => 'form-control'])

            ->ajoutLabelFor('subject', 'Subject :')
            ->ajoutInput('text', 'subject', ['id' => 'subject', 'class' => 'form-control'])
            
            ->ajoutLabelFor('message', 'Message :')
            ->ajoutTextarea('message', '', ['style' => 'resize: none;', 'class' => 'form-control mt-3 mb-1'])

            ->ajoutButton('Envoyer', ['class' => 'btn btn-primary mt-3 mb-1'])

            ->finForm();

            $this->render('contact/contact', ['contactForm' => $form->create()]);
    }
}