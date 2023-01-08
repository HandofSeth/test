<?php

namespace App\Controller;

use App\Service\DistanceService;
use App\Repository\CitiesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QueryController extends AbstractController
{
    #[Route('/query', name: 'app_query')]
    public function index(Request $request, CitiesRepository $citiesRepository, SerializerInterface $serializer): Response
    {
    
            if($request->isXmlHttpRequest())
            {
                $target = $request->request->get('target');

                switch($target)
                {

                    case 'localiseCity':

                        $cities = $citiesRepository->findCityByName($value)  ;   
                        /* $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, 'http://google.fr'); */
                        break;
                    case'Allcity' :
                        $value = $request->request->get('value');
                        $allCities = null;
                        $allCities = $citiesRepository->findOneBySomeField($value)  ;   
                        $response = $serializer->serialize($allCities,'json');
                        break;
                }
                return new Response($response);


            }



        return $this->render('query/index.html.twig', [
            'controller_name' => 'QueryController',
        ]);
    }



    #[Route('/localise', name: 'app_query')]
    public function localise(Request $request, CitiesRepository $citiesRepository, SerializerInterface $serializer, DistanceService $distanceService): Response
    {
        $arrayResult =[];
        $depart = 'Nîmes';
        $result = $citiesRepository->findCityByName($depart);
        $depart =[$result[0]->getGpsLat(),$result[0]->getGpsLng()];
       
        $destination=['Paris','Montpellier','Marseille'];
        foreach($destination as $city)
        {
            
          $ville = $citiesRepository->findCityByName($city);
          array_push($arrayResult,[$ville[0]->getGpsLat(),$ville[0]->getGpsLng()]);
        }

            $array= [$depart, $arrayResult];
                foreach($array as  $city)
                {
                      

                }
                
                /* $distanceService->distance($lat1, $lng1, $lat2, $lng2,$miles); */


        return $this->render('query/index.html.twig', [
            'controller_name' => 'QueryController',
        ]);
    }



}
