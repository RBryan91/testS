<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\MessageType;

class PostController extends AbstractController
{
    #[Route('/post/{id}', name: 'app_post')]
    public function index(EntityManagerInterface $entityManager ,int $id , MessageRepository $message , MessageRepository $messageRepository , Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }


        $messages = $message->findBy(['id' => $id]);
        $repository = $messageRepository->findAll();


        $Comm = new Message;
        $FormComm = $this->createForm(MessageType::class, $Comm);
        $FormComm->handleRequest($request);
        if($FormComm->isSubmitted() && $FormComm->isValid())
        {
            //$user = $this->getUser();
            // dd($user->getId());
            $Comm->setUser($this->getUser());
            $Comm->setDate(new \DateTime());
            $Comm->setidParent($id);
            //dd($Comm);

            $entityManager->persist($Comm);
            $entityManager->flush();

            return $this->redirectToRoute('app_post', ["id"=>$id] );
        }

        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'formComm' => $FormComm->createView(),
            'id' => $messages,
            'user' => $repository,
        ]);
    }
    #[Route('/post/delete/{id}', name: "app_delete2")]
    public function delete2(EntityManagerInterface $entityManager, Message $message): Response
     {  
        $id = $message->getIdParent();
        

         $entityManager->remove($message); 
         $entityManager->flush();
 
         return $this->redirectToRoute('app_post', ["id"=>$id] );
     }
 
     #[Route('/edit/{id}', name: 'app_edit2')]
    public function update2(Request $request , Message $message ,EntityManagerInterface $entityManager): Response
    {
        $edit = $this->createForm(MessageType::class, $message);
        $edit->handleRequest($request);
        if($edit->isSubmitted() && $edit->isValid())
        {
            $entityManager->flush();
            $id = $message->getIdParent();

            return $this->redirectToRoute('app_post', ["id"=>$id] );
        }
        
        return $this->render('edit/index.html.twig', [
            'edit' => $edit->createView(),
            
            
        ]);

    }
}
