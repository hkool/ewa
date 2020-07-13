<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\FileParam;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;


final class ContactController extends AbstractController
{
    private EntityManagerInterface $em;



    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

      public function findAllAction(): JsonResponse
    {
        $contacts = $this->em->getRepository(Contact::class)->findBy(['subscribed' => true,]);


    }


    public function delete(Request $request, $id): JsonResponse
    {

        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository(Contact::class)->find($id);

        $em->remove($contact);
        $em->flush();

        $data = $this->serializer->serialize($contact, JsonEncoder::FORMAT);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

   
}
