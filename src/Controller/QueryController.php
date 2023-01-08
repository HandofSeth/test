<?php

namespace App\Controller;

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
}
