<?php

namespace App\Controller;

use App\Entity\MessagePost;
use App\Entity\TicketPost;
use App\Form\TicketPostType;
use App\Repository\UserRepository;
use App\Repository\TicketPostRepository;
use App\Repository\MessagePostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/ticket/post")
 */
class TicketPostController extends AbstractController
{
    /**
     * @Route("/", name="ticket_post_index", methods={"GET"})
     */
    public function index(TicketPostRepository $ticketPostRepository, UserRepository $userRepository): Response
    {

        // dump($ticketPostRepository->findAll());
        // // dump($this->getUser());
        // die;
        $user = $this->getUser();
        if ($user ) {
            $tickets = $ticketPostRepository->findByUser(["user_id" => $user->getId()]);
        } else {
            $tickets = $ticketPostRepository->findAll();
        }
        
        return $this->render('ticket_post/index.html.twig', [
            'ticket_posts' => $tickets,
            'users' => $userRepository->findAll(),
            'mycurrentuser' => $user
        ]);
    }

    /**
     * @Route("/new", name="ticket_post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $ticketPost = new TicketPost();
        $ticketPost->setUser($this->getUser());
        $form = $this->createForm(TicketPostType::class, $ticketPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dump($ticketPost);
            $ticketPost->setCreatedAt(new \DateTime);
            $ticketPost->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticketPost);
            $entityManager->flush();

            return $this->redirectToRoute('ticket_post_index');
        }

        return $this->render('ticket_post/new.html.twig', [
            'ticket_post' => $ticketPost,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ticket_post_show", methods={"GET"})
     */
    public function show(TicketPost $ticketPost): Response
    {
        return $this->render('ticket_post/show.html.twig', [
            'ticket_post' => $ticketPost,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ticket_post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TicketPost $ticketPost): Response
    {
        $form = $this->createForm(TicketPostType::class, $ticketPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ticket_post_index');
        }

        return $this->render('ticket_post/edit.html.twig', [
            'ticket_post' => $ticketPost,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ticket_post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TicketPost $ticketPost, MessagePostRepository $messagePostRepository): Response
    {

        if ($this->isCsrfTokenValid('delete'.$ticketPost->getId(), $request->request->get('_token'))) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $messages = $messagePostRepository->findByTicket($ticketPost->getId());
            foreach ($messages as $message) {
                $entityManager->remove($message);
            }
            $entityManager->remove($ticketPost);
            

            $entityManager->flush();
        }
        

        return $this->redirectToRoute('ticket_post_index');
    }
}
