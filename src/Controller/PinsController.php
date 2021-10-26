<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Form\PinType;
use App\Repository\PinRepository;
use App\Repository\UserRepository;
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


    #[Route('/', name: 'app_home', methods:"GET")]
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

    


    #[Route('/pins/create', name: 'app_pins_create',methods:["GET","POST"])]
    public function create(Request $req, UserRepository $userRepo):Response{

        $pin = new Pin;

        $form = $this->createForm(PinType::class,$pin);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){
            $pabios = $userRepo->findOneBy(['id' => 1]);
            $pin->setUser($pabios);
            $this->em->persist($pin);
            $this->em->flush();

            $this->addFlash('success','l\'article a été ajouté avec succès');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pins/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/pins/{id<[0-9]+>}/edit",name="app_pins_edit",methods={"GET","POST"})
     */
    public function edit( Request $req,Pin $pin):Response{
        // prochaine etape changer le POST EN PUT 
        $form = $this->createForm(PinType::class,$pin);
        
        
        $form->handleRequest($req);

            if($form->isSubmitted() && $form->isValid()){
                 
                $this->em->flush();

            $this->addFlash('success','l\'article a été modifier  avec succès');

    
                return $this->redirectToRoute('app_home');
            }

        return $this->render('pins/edit.html.twig',[
            'pin' => $pin,
            'form' => $form->createView()
        ]);
    } 
    
     /**
     * @Route("/pins/{id<[0-9]+>}/delete",name="app_pins_delete",methods={"GET","POST"})
     */
    public function delete( Request $req,Pin $pin):Response{
         // boeug sur l'annotation methods="DELETE" a revoir

        //supprime si le token envoyer par l'utiisateur est valide 
        if($this->isCsrfTokenValid('pin_deletion_'.$pin->getId(),$req->request->get('csrf_token'))){
             $this->em->remove($pin);
            $this->em->flush();

            $this->addFlash('info','l\'article a été supprimer avec succès');

        }
       

        return $this->redirectToRoute('app_home');
 
    }
}
