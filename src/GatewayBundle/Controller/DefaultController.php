<?php

namespace GatewayBundle\Controller;

use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Encoder\JsonDecode;

class DefaultController extends Controller
{
    public function indexAction( SessionInterface $session)
    {
        if ($session->get("user")){
            return $this->render('GatewayBundle:Default:index.html.twig');
        }
        return $this->redirectToRoute("login");
    }

    public function listAction( SessionInterface $session)
    {
        if ($session->get("user")){
            $orm = $this->getDoctrine()->getConnection();

            $query = "select id,name,lat,lon,lrrid,state from bss where  (lat != '' ) and (lat is not null) and (lon != '' ) and (lon is not null);";
            $stmt = $orm->prepare($query);
            $stmt->execute();
            $bss = $stmt->fetchAll();

            return new JsonResponse($bss);
        }
        return $this->redirectToRoute("login");
    }

    public function deleteAction(Request $req, SessionInterface $session, $id){
        if ($session->get("user")){
            $orm = $this->getDoctrine()->getConnection();

            $query = "delete from bss where id = ".$id." ;";
            echo $query;
            $stmt = $orm->prepare($query);
            $stmt->execute();
            return new Response("1");
        }
        return $this->redirectToRoute("login");
    }


    public function addAction(Request $req, SessionInterface $session){
        if ($session->get("user")){
            if ($req->isMethod("post")) {
                $orm = $this->getDoctrine()->getConnection();

                $query = "select max(CONV(lrrid, 16, 10)) as lrrid from bss;";
                $stmt = $orm->prepare($query);
                $stmt->execute();
                $lrrid = $stmt->fetch();

                $lrrid = str_pad( strtoupper(dechex($lrrid["lrrid"] +1 )), 7 , "0", STR_PAD_LEFT );
                $name = $req->get("name");
                $model = $req->get("model");
                $version = $req->get("version");
                $vendor = $req->get("vendor");
                $description = $req->get("description");
                $lat = $req->get("lat");
                $lng = $req->get("lng");

                $query = "insert into bss (lrrid , name , `model/commercialName`, `version/0`, lat, lon, `vendor/name`, `vendor/commercialDescription` )
                          values (:lrrid, :name, :model, :version, :lat, :lon, :vendor, :description) ";
                $stmt = $orm->prepare($query);
                $stmt->bindValue("lrrid", $lrrid);
                $stmt->bindValue("name", $name);
                $stmt->bindValue("model", $model);
                $stmt->bindValue("version", $version);
                $stmt->bindValue("lat", $lat);
                $stmt->bindValue("lon", $lng);
                $stmt->bindValue("vendor", $vendor);
                $stmt->bindValue("description", $description);
                $stmt->execute();

                $this->addFlash("bss_add","station added successfully");
            }
        }
        return $this->redirectToRoute("gateway_homepage");
    }

    public function heatmapAction( SessionInterface $session)
    {
        if ($session->get("user")){
            return $this->render('GatewayBundle:Default:heatmap.html.twig');
        }
        return $this->redirectToRoute("login");
    }

    public function fetch($obj){
        return $obj["lrrid"];
    }

    public function fetch_apiAction(Request $req, $token, SessionInterface $session){
        //token :
        //eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6WyJTVUJTQ1JJQkVSOjEyODg3MiJdLCJleHAiOjE1OTMwNzU3NDcsImp0aSI6ImQxOTkxYWE1LTdhNmItNGYwOC05YTIzLWRiNjVjNWRkMjcyNyIsImNsaWVudF9pZCI6ImRldjEtYXBpL2FvdWFsaUAzcy5jb20udG4ifQ.qW5d3fX_ELAcW0Ggq7-S6V9nt_PA7NDlXEt2LvbrVa1YU4Lq5v16c-nMAAfDSyvCWShBlnHbocEYbC7JnxcKIQ

        $orm = $this->getDoctrine()->getConnection();
        $bss_tmp =[];

        $query = "select lrrid from bss ";
        $stmt = $orm->prepare($query);
        $stmt->execute();
        $bss = $stmt->fetchAll();

        foreach ($bss as $b){
            array_push($bss_tmp, $b["lrrid"]) ;
        }


        $api_url = "https://dx-api.thingpark.com/core/latest/api/baseStations" ;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Bearer '.$token.'#&#33;/BaseStation/get_baseStations';
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($curl);
        $tmp =  json_decode($result);
        try {
            $tmp =  json_decode($result);
            echo $tmp->code ;
            if ($session->get("api_error") == null)
                $session->set("api_error", 1);
            $session->set("api_error",$session->get("api_error")+1);
            if ($session->get("api_error") >= 10) {
                $session->set("api_error", 0);
                return new Response("please check token validity or open the api portal (https://dx-api.thingpark.com/core/latest/swagger-ui/index.html?shortUrl=tpdx-core-api-contract.json ) and run a request to refresh the token ");
            }
            return $this->redirectToRoute("gateway_fetch_api", array("token"=>$token));
        }
        catch (\Exception  $ex){
            $session->set("api_error",0);
            $tmp =  json_decode($result);
            $tmp_counter = 0;
            foreach ($tmp as $t){
                if (!in_array($t->id,$bss_tmp)){
                    $tmp_counter += 1;
                    $query = "insert into bss (name , lrrID , healthState, lat, lon) values (:name,:lrrID,:healthState, 0, 0 )";
                    $stmt = $orm->prepare($query);
                    $stmt->bindValue("name", $t->name);
                    $stmt->bindValue("lrrID", $t->id);
                    $stmt->bindValue("healthState", $t->administrationState);
                    $stmt->execute();
                    echo "found ".$t->id.":  added to database \n";
                }
            }

            if ($tmp_counter ==0 ){
                return new Response("0 new stations found <br> <a href='/gateway'> retour  </a>");
            }
            return new Response("<a href='/gateway'> retour  </a>");
        }
    }

    public function heatmap_listAction(Request $req ,  SessionInterface $session)
    {
        if ($session->get("user")){
            $orm = $this->getDoctrine()->getConnection();

            if ($req->query->get("date")){
                $query_count = "select count(*) as total from network where (Latitude != '') and (Longitude != '') and (STR_TO_DATE(Timestamp, '%Y-%m-%d') = '".$req->query->get("date")."') ";
                $stmt_count = $orm->prepare($query_count);
                $stmt_count->execute();
                $count = $stmt_count->fetchAll()[0];
                if ($count["total"] ==0 ){
                    return new JsonResponse([["Latitude"=>0,"Longitude"=>0,"uplink"=>0,"bestlrrid"=>0,"Timestamp"=>"None", "Distance"=>0   ], ["total"=>0]]);
                }

                if ($req->query->get("index") != null) {
                    $query = "select Latitude , Longitude , `Uplink Estimated Signal Power(dBm)` as uplink, `BEST LRR ID` as bestlrrid, `BEST LRR LAT` as bestlrrlat,
                         `BEST LRR LONG` as bestlrrlon, Distance, Timestamp  from network 
                          where (Latitude != '') and (Longitude != '') and (STR_TO_DATE(Timestamp, '%Y-%m-%d') = '".$req->query->get("date")."') 
                          order by STR_TO_DATE(Timestamp,'%Y-%m-%d %H:%i:%s')  desc limit " . $req->query->get("index") . " , 1 ; ";
                } else {
                    $query = "select Latitude , Longitude , `Uplink Estimated Signal Power(dBm)` 
                as uplink, `BEST LRR ID` as bestlrrid, `BEST LRR LAT` as bestlrrlat, `BEST LRR LONG` as bestlrrlon, Distance, Timestamp  from network 
                where (Latitude != '') and (Longitude != '') and (STR_TO_DATE(Timestamp, '%Y-%m-%d') = '".$req->query->get("date")."') 
                 order by STR_TO_DATE(Timestamp,'%Y-%m-%d %H:%i:%s') desc  limit 1;";
                }
                $stmt = $orm->prepare($query);
                $stmt->execute();
                $bss = $stmt->fetchAll()[0];

                return new JsonResponse([$bss, $count]);
            }
            else {


                $query_count = "select count(*) as total from network where (Latitude != '') and (Longitude != '') ";
                $stmt_count = $orm->prepare($query_count);
                $stmt_count->execute();
                $count = $stmt_count->fetchAll()[0];
                if ($count["total"] ==0 ){
                    return new JsonResponse([["Latitude"=>0,"Longitude"=>0,"uplink"=>0,"bestlrrid"=>0,"Timestamp"=>"None", "Distance"=>0   ], ["total"=>0]]);
                }
                if ($req->query->get("index") != null) {
                    $query = "select Latitude , Longitude , `Uplink Estimated Signal Power(dBm)` as uplink, `BEST LRR ID` as bestlrrid, `BEST LRR LAT` as bestlrrlat,
                         `BEST LRR LONG` as bestlrrlon, Distance, Timestamp  from network 
                          where (Latitude != '') and (Longitude != '') 
                          order by STR_TO_DATE(Timestamp,'%Y-%m-%d %H:%i:%s')  desc limit " . $req->query->get("index") . " , 1 ; ";
                } else {
                    $query = "select Latitude , Longitude , `Uplink Estimated Signal Power(dBm)` 
                as uplink, `BEST LRR ID` as bestlrrid, `BEST LRR LAT` as bestlrrlat, `BEST LRR LONG` as bestlrrlon, Distance, Timestamp  from network 
                order by STR_TO_DATE(Timestamp,'%Y-%m-%d %H:%i:%s') desc  limit 1;";
                }
                $stmt = $orm->prepare($query);
                $stmt->execute();
                $bss = $stmt->fetchAll()[0];

                return new JsonResponse([$bss, $count]);
            }
        }
        return $this->redirectToRoute("login");
    }
}
