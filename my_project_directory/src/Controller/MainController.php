<?php

namespace App\Controller;
use App\Entity\Message;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;


class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    
    
    public function index(Request $request , EntityManagerInterface $entityManager, MessageRepository $messageRepository): Response
    {
        
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $repository = $messageRepository->findAll();

        $message = new Message;
        $Formmessage = $this->createForm(MessageType::class, $message);
        $Formmessage->handleRequest($request);
        if($Formmessage->isSubmitted() && $Formmessage->isValid())
        {
            //$user = $this->getUser();
            // dd($user->getId());
            $message->setUser($this->getUser());
            $message->setDate(new \DateTime());
            //dd($message);
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_main');
        }

         

        return $this->render('main/index.html.twig', [
            'message' => $message,
            'user' => $repository,
            'controller_name' => 'MainController',
            'formmessage' => $Formmessage->createView(),
            
        ]);
    }

    #[Route('/post/edit/{id}', name: 'app_edit')]
    public function update(Request $request , Message $message ,EntityManagerInterface $entityManager): Response
    {
        $edit = $this->createForm(MessageType::class, $message);
        $edit->handleRequest($request);
        if($edit->isSubmitted() && $edit->isValid())
        {
            $entityManager->flush();

            return $this->redirectToRoute('app_main');
        }
        
        return $this->render('edit/index.html.twig', [
            'edit' => $edit->createView(),
            
            
        ]);

    }

   #[Route('/delete/{id}', methods: ['GET' , 'DELETE'] , name: "app_delete")]
   public function delete(EntityManagerInterface $entityManager, Message $message): Response
    {
        
        $entityManager->remove($message); 
        $entityManager->flush();

        return $this->redirectToRoute('app_main');
    }

    
}
