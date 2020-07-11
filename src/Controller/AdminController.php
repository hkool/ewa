<?php


namespace App\Controller;


use App\Entity\Post;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use App\Repository\PartnerRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/showBeheer", name="showBeheer")
     */
    public function showBeheerAction()
    {

        return $this->render('admin/showBeheer.html.twig');
    }

//    beheer nieuws
    /**
     * @Route("/beheerNieuws", name="beheerNieuws", methods={"GET"})
     */
    public function beheerNieuwsAction(PostRepository $postRepository): Response
    {
        return $this->render('admin/post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }
    //    beheer partners
    /**
     * @Route("/beheerNieuws", name="beheerPartners", methods={"GET"})
     */
    public function beheerPartnersAction(PartnerRepository $partnerRepository): Response
    {
        return $this->render('admin/partner/index.html.twig', [
            'partners' => $partnerRepository->findAll(),
        ]);
    }
    //    beheer informatie
    /**
     * @Route("/beheerInformatie", name="beheerInformatie", methods={"GET"})
     */
    public function beheerInformatieAction(DocumentRepository $informatieRepository): Response
    {
        return $this->render('admin/document/index.html.twig', [
            'documents' => $informatieRepository->findAll(),
        ]);
    }


}