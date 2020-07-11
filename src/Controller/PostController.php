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
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('admin/post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

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

//            $img = $form->get('imageFile')->getData();
//            $post->setTitle($title);
//            $post->setContent($content);
//            define('UPLOAD_DIR', 'images/news/');
//            $post->setImage($img);
//            $img = $post->getImg($img);
//            $img = str_replace('data:image/jpeg;base64,', '', $img);
//            $img = str_replace('data:image/png;base64,', '', $img);
//            $img = str_replace(' ', '+', $img);
//            $data = base64_decode($img);
//            $file = uniqid() . '.jpeg';
//            $read = UPLOAD_DIR . $file;
//            $success = file_put_contents($read, $data);
//            $post->setImg($file);

            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('post_index');

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

        if ($form->isSubmitted() && $form->isValid()) {

//
//                $img=$form->get('img')->getData();
//                $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_BASENAME);
//                // this is needed to safely include the file name as part of the URL
//                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
//                $newFilename = $safeFilename . '-' . uniqid() . '.' . $img->guessExtension();
//
//                // Move the file to the directory where brochures are stored
//                try {
//                    $img->move(
//                        $this->getParameter('images_directory'),
//                        $newFilename
//                    );
//                } catch (FileException $e) {
//                    // ... handle exception if something happens during file upload
//                }
//                $post->setImg($newFilename);

            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('post_index');
    }


        return $this->render('admin/post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
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

    /**
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }
}
