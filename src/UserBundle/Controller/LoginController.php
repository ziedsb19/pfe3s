<?php
namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserBundle\Entity\Users;

class LoginController extends Controller
{
    public function loginAction(Request $request, SessionInterface $session){

        if ($request->isMethod("post")){
            $orm = $this->getDoctrine()->getManager();
            $repo = $orm->getRepository("UserBundle:Users");

            $email = $request->get("email");
            $password = md5($request->get("password")) ; 
            $user= $repo->findOneBy(array("email"=>$email, "password"=>$password));

            if ($user != null){
                $session->set("user",$user);
                return $this->redirectToRoute("index");
            }

            $errors = "bad coordinates";
            return $this->render("UserBundle:login:login.html.twig", array("errors"=>$errors));
        }
        $errors = "";
        return $this->render("UserBundle:login:login.html.twig", array("errors"=>$errors));
    }

    public function logoutAction(SessionInterface $session){
        $session->remove("user");
        return $this->redirectToRoute("login");
    }

    public function recupAction(Request $req  ,SessionInterface $session){
        if ($req->isMethod("post")){
            $orm = $this->getDoctrine()->getManager();
            $repo = $orm->getRepository("UserBundle:Users");

            $email = $req->get("email");
            $user= $repo->findOneBy(array("email"=>$email));

            if ($user != null){
                $password = $this->generateRandomString(8);
                $message = \Swift_Message::newInstance();
                $message = (new \Swift_Message('password change'))
                    ->setFrom('projetpfe3s@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(  $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'Emails/email.html.twig',
                        ["username"=>$user->getUsername(), "password"=>$password]
                    ),
                        'text/html');

                $this->get("mailer")->send($message);

                $user->setPassword(md5($password));
                $orm->flush();

                return $this->render("UserBundle:login:recup_verif.html.twig");
            }
            return $this->render("UserBundle:login:recup.html.twig", ["errors"=>"user not found"]);
        }
        return $this->render("UserBundle:login:recup.html.twig", ["errors"=>""]);
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
