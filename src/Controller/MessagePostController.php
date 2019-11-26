<?php

namespace App\Controller;

use App\Entity\MessagePost;
use App\Form\MessagePostType;
use App\Repository\MessagePostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/message/post")
 */
class MessagePostController extends AbstractController
{
    /**
     * @Route("/", name="message_post_index", methods={"GET"})
     */
    public function index(MessagePostRepository $messagePostRepository): Response
    {
        return $this->render('message_post/index.html.twig', [
            'message_posts' => $messagePostRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="message_post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $messagePost = new MessagePost();
        $messagePost->setUser($this->getUser());
        // $messagePost->setTicket($this->getTicket());
        $form = $this->createForm(MessagePostType::class, $messagePost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messagePost->setCreatedAt(new \DateTime);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($messagePost);
            $entityManager->flush();

            return $this->redirectToRoute('ticket_post_index');
        }

        return $this->render('message_post/new.html.twig', [
            'message_post' => $messagePost,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_post_show", methods={"GET"})
     */
    public function show(MessagePost $messagePost): Response
    {
        return $this->render('message_post/show.html.twig', [
            'message_post' => $messagePost,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="message_post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MessagePost $messagePost): Response
    {
        $form = $this->createForm(MessagePostType::class, $messagePost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ticket_post_index');
        }

        return $this->render('message_post/edit.html.twig', [
            'message_post' => $messagePost,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MessagePost $messagePost): Response
    {
        if ($this->isCsrfTokenValid('delete'.$messagePost->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($messagePost);
            $entityManager->flush();
        }

        return $this->redirectToRoute('message_post_index');
    }
}
