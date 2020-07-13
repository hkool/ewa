<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Form\PartnerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/partner")
 */
class PartnerController extends AbstractController
{
    /**
     * @Route("/", name="partner_index", methods={"GET"})
     */
    public function index(): Response
    {
        $partners = $this->getDoctrine()
            ->getRepository(Partner::class)
            ->findAll();

        return $this->render('admin/partner/index.html.twig', [
            'partners' => $partners,
        ]);
    }

    /**
     * @Route("/new", name="partner_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('partner_index');
        }

        return $this->render('admin/partner/new.html.twig', [
            'partner' => $partner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="partner_show", methods={"GET"})
     */
    public function show(Partner $partner): Response
    {
        return $this->render('admin/partner/show.html.twig', [
            'partner' => $partner,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="partner_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Partner $partner): Response
    {
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->persist($partner);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partner_index');
        }

        return $this->render('admin/partner/edit.html.twig', [
            'partner' => $partner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="partner_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Partner $partner): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partner->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($partner);
            $entityManager->flush();
        }

        return $this->redirectToRoute('partner_index');
    }
}
