<?php

namespace DashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DefaultController extends Controller
{
    public function indexAction(SessionInterface $session, Request $req)
    {
        if ($session->get("user")) {
            $orm = $this->getDoctrine()->getManager();
            $repo = $orm->getRepository("DashBundle:Tpwsystem");
            if ($req->isMethod("post")){
                $bss = $req->get("bss");
            }
            else{
                $bss = "000031E5";
            }
            $one = $this->get_one_bss($bss);
            $bss = $repo->findOneBy(array("lrrid"=>$bss));
            return $this->render('DashBundle:Default:index.html.twig', array("bss"=>$bss, "all"=>$this->get_all_bss_name(), "one"=>$one));
        }
        return $this->redirectToRoute("login");
    }

    public function alarmsAction(SessionInterface $session, Request $req)
    {
        if ($session->get("user")) {
            return $this->render('DashBundle:Default:alarms.html.twig');
        }
        return $this->redirectToRoute("login");

    }

    private function get_one_bss($bss){
        $orm = $this->getDoctrine()->getConnection();

        $query = "select name , `model/commercialName` as model , lrrID, state, healthState , `version/0` as version from bss where lrrid='".strtolower($bss)."';";
        $stmt = $orm->prepare($query);
        $stmt->execute();
        $bss = $stmt->fetch();

        return $bss;
    }

    private function get_all_bss_name(){
        $orm = $this->getDoctrine()->getConnection();

        $query = "select distinct (b.lrrid) ,b.name from bss  b inner join tpwsystem t on b.lrrid = t.lrrid ;";
        $stmt = $orm->prepare($query);
        $stmt->execute();
        $bss = $stmt->fetchAll();

        return $bss;

    }

    private function get_all_bss(){
        $orm = $this->getDoctrine()->getManager();
        $repo = $orm->getRepository("DashBundle:Tpwsystem");
        $bss = $repo->findAll();
        $bss_names = [];
        foreach ($bss as $b ){
            $bss_names[] = $b->getLrrid();
        }
        return array_unique( $bss_names ) ;
    }
}
