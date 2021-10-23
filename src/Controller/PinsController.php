<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PinsController extends AbstractController
{
    #[Route('/pins', name: 'app_home')]
    public function index(PinRepository $pr): Response
    {

        $pins = $pr->findAll();


        return $this->render('pins/index.html.twig', [
            'pins' => $pins
        ]);
    }


    /**
     * @Route("/pins/{id<[0-9]+>}",name="app_pins_show")
     */
    public function show(Pin $pin):Response{
        return $this->render('pins/show.html.twig',['pin' => $pin]);
    }   
}
