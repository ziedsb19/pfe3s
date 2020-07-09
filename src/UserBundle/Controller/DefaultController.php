<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UserBundle\Entity\Users;

class DefaultController extends Controller
{
    public function indexAction(SessionInterface $session){
        if ($session->get("user")) {
            if ($session->get("user")->getSuperAdmin() == 1) {
                $orm = $this->getDoctrine()->getManager();
                $repo = $orm->getRepository("UserBundle:Users");
                $users = $repo->findAll();

                return $this->render('UserBundle:Default:index.html.twig', array("users" => $users));
            }
            return $this->redirectToRoute("gateway_homepage");
        }
        return $this->redirectToRoute("login");
    }

    public function add_userAction(Request $request, SessionInterface $session)
    {
        if ($session->get("user")) {
            if ($session->get("user")->getSuperAdmin() == 1) {
                if ($request->isMethod("post")) {
                    $orm = $this->getDoctrine()->getManager();
                    $repo = $orm->getRepository("UserBundle:Users");

                    $username = $request->get("username");
                    $email = $request->get("email");
                    $password = md5($request->get("password"));

                    $qb = $orm->createQueryBuilder();
                    $qb->select('u')
                        ->from('UserBundle:Users', 'u')
                        ->where('u.username = ?1')
                        ->orWhere('u.email= ?2')
                        ->setParameters(array(1 => $username, 2 => $email));
                    $query = $qb->getQuery();
                    try {
                        $user = $query->getSingleResult();
                        $errors = "0";
                        return $this->render('UserBundle:Default:add_user.html.twig', array("errors" => $errors));

                    } catch (\Exception $ex) {

                        $errors = "1";
                        $user = new Users();
                        $user->setUsername($username);
                        $user->setEmail($email);
                        $user->setPassword($password);

                        $orm->persist($user);
                        $orm->flush();
                        return $this->render('UserBundle:Default:add_user.html.twig', array("errors" => $errors));
                    }

                }
                $errors = "2";
                return $this->render('UserBundle:Default:add_user.html.twig', array("errors" => $errors));
            }
            return $this->redirectToRoute("gateway_homepage");

        }
        return $this->redirectToRoute("login");

    }

    public function update_userAction(Request $request, SessionInterface $session ,$id){
        if ($session->get("user")) {
            if ($session->get("user")->getSuperAdmin() == 1) {
                $orm = $this->getDoctrine()->getManager();
                $repo = $orm->getRepository("UserBundle:Users");
                $user = $repo->find($id);
                if ($user == null)
                    throw new NotFoundHttpException();

                if ($request->isMethod("post")) {
                    $password = md5($request->get("password"));
                    $user->setPassword($password);

                    $orm->flush();
                    $this->addFlash("modif","password modified successfully");
                    return $this->redirectToRoute("index");
                }
                return $this->render('UserBundle:Default:update_user.html.twig');
            }
            return $this->redirectToRoute("gateway_homepage");

        }
        return $this->redirectToRoute("login");

    }

    public function modif_userAction(Request $request, SessionInterface $session ,$id){
        if ($session->get("user")) {

                $orm = $this->getDoctrine()->getManager();
                $repo = $orm->getRepository("UserBundle:Users");
                $user = $repo->find($id);
                if ($user == null)
                    throw new NotFoundHttpException();

                if ($request->isMethod("post")) {
                    $username = $request->get("username");
                    $password = $request->get("password");
                    $nom = $request->get("nom");
                    $prenom = $request->get("prenom");
                    $adresse = $request->get("adresse");
                    $tel = $request->get("tel");

                    if ($username)
                        $user->setUsername($username);
                    if ($password)
                        $user->setPassword(md5($password));
                    if ($nom)
                        $user->setNom($nom);
                    if ($prenom)
                        $user->setPrenom($prenom);
                    if ($adresse)
                        $user->setAdresse($adresse);
                    if ($tel)
                        $user->setTel($tel);

                    $orm->flush();

                    return $this->redirectToRoute("index");
                }
                return $this->render('UserBundle:Default:modif_user.html.twig', array("user"=>$user));
        }

        return $this->redirectToRoute("login");
    }


    public function delete_user_idAction(Request $request , SessionInterface $session ,$id){
        if ($session->get("user")) {
            if ($session->get("user")->getSuperAdmin() == 1) {
                $orm = $this->getDoctrine()->getManager();
                $repo = $orm->getRepository("UserBundle:Users");
                $user = $repo->find($id);
                if (!$user)
                    throw new NotFoundHttpException();
                $orm->remove($user);
                $orm->flush();
                $this->addFlash("delete", "user deleted successfully");
                return $this->redirectToRoute("index");
            }
            return $this->redirectToRoute("gateway_homepage");

        }
        return $this->redirectToRoute("login");
    }

// this methods below are not recommended.

/*

    ***********************************************************
    ***********************************************************
    ***********************************************************
    ***********************************************************
 *
*/
    public function delete_userAction(Request $request){
        $orm = $this->getDoctrine()->getManager();
        $repo = $orm->getRepository("UserBundle:Users");
        if ($request->isMethod("post")) {
            $username = $request->get("username");
            $email = $request->get("email");
            $id = intval($request->get("id"));

            $qb = $orm->createQueryBuilder();
            $qb->select('u')
                ->from('UserBundle:Users', 'u')
                ->where('u.username = ?1')
                ->orWhere('u.email= ?2')
                ->orWhere('u.id= ?3')
                ->setParameters(array(1 => $username, 2 => $email, 3 => $id));
            $query = $qb->getQuery();

            try {
                $user = $query->getSingleResult();
                $orm->remove($user);
                $orm->flush();
                $errors = "user deleted ";
                return $this->render('UserBundle:Default:delete_user.html.twig', array("errors" => $errors));

            } catch (\Exception $ex) {

                $errors = "user not found ";
                return $this->render('UserBundle:Default:delete_user.html.twig', array("errors" => $errors));
            }
        }
        $errors = "";
        return $this->render('UserBundle:Default:delete_user.html.twig', array("errors" => $errors));

    }

    public function find_userAction(Request $request){
        $orm = $this->getDoctrine()->getManager();
        $repo = $orm->getRepository("UserBundle:Users");
        if ($request->isMethod("post")) {
            $username = $request->get("username");
            $email = $request->get("email");
            $id = intval($request->get("id"));

            $qb = $orm->createQueryBuilder();
            $qb->select('u')
                ->from('UserBundle:Users', 'u')
                ->where('u.username = ?1')
                ->orWhere('u.email= ?2')
                ->orWhere('u.id= ?3')
                ->setParameters(array(1 => $username, 2 => $email, 3 => $id));
            $query = $qb->getQuery();

            try {
                $user = $query->getSingleResult();
                return $this->redirectToRoute("user_update", array("id"=> $user->getId()));

            } catch (\Exception $ex) {

                $errors = "user not found ";
                return $this->render('UserBundle:Default:find_user.html.twig', array("errors" => $errors));
            }
        }
        $errors = "";
        return $this->render('UserBundle:Default:find_user.html.twig', array("errors" => $errors));

    }
}
