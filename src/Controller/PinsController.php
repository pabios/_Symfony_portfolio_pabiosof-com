<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PinsController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }


    #[Route('/pins', name: 'app_home', methods:"GET")]
    public function index(PinRepository $pr): Response
    {

        $pins = $pr->findBy([],['createdAt' => 'DESC']);


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

     /**
     * @Route("/pins/{id<[0-9]+>}/edit",name="app_pins_edit",methods={"GET","POST"})
     */
    public function edit( Request $req,Pin $pin):Response{

        $form = $this->createFormBuilder($pin)
            ->add('title',TextType::class)
            ->add('description',TextareaType::class)
            ->getForm();
            $form->handleRequest($req);

            if($form->isSubmitted() && $form->isValid()){
                 
                $this->em->flush();
    
                return $this->redirectToRoute('app_home');
            }

        return $this->render('pins/edit.html.twig',[
            'pin' => $pin,
            'form' => $form->createView()
        ]);
    }     


    #[Route('/pins/create', name: 'app_pins_create',methods:["GET","POST"])]
    public function create(Request $req):Response{

        $pin = new Pin;

        $form = $this->createFormBuilder($pin)
            ->add('title',TextType::class)
            ->add('description',TextareaType::class)
            ->getForm();

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){
            /**$data = $form->getData();
                $pin = new Pin;
                $pin->setTitle($data['title']);
                $pin->setDescription($data['description']);
            **/

            // dd($pin)
            $this->em->persist($pin);
            $this->em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pins/create.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
