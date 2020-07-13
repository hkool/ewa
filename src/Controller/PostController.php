<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/post")
 */
class PostController extends AbstractController
{

    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->isSubmitted() ) {
                $title = $form->get('title')->getData();
            if (empty($title)) {
                throw new BadRequestHttpException('title cannot be empty');
            }

            $content = $form->get('content')->getData();
            if (empty($content)) {
                throw new BadRequestHttpException('content cannot be empty');
            }
            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('beheerNieuws');
        }
            return $this->render('admin/post/new.html.twig', [
                'post' => $post,
                'form' => $form->createView(),
            ]);
        }

    /**
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('beheerNieuws');
        }
        return $this->render('admin/post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
    /**
 * @Route("/{id}", name="post_delete", methods={"DELETE"})
 */
    public function delete(Request $request, $id): Response
    {
        $post=$this->getDoctrine()->getRepository(Post::class)->find($id);
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('beheerNieuws');
    }
    /**
     * @Route("/{id}", name="post_show", methods={"GET"})
     */
    public function show(Post $post): Response
    {
        return $this->render('admin/post/show.html.twig', [
            'post' => $post,
        ]);
    }


}
