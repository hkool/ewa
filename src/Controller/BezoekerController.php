<?php


namespace App\Controller;


use App\Entity\Contact;
use App\Entity\Document;
use App\Entity\Partner;
use App\Entity\Post;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

class BezoekerController extends AbstractController
{
    private EntityManagerInterface $em;
    private SerializerInterface $serializer;
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }
    /**
     * @Route("/", name="homeCreate")
     */
    function indexAction(Request $request, \Swift_Mailer $mailer)
    {
        $nieuwsberichten = $this->em->getRepository(Post::class)->findLatest();
        $partners=$this->em->getRepository(Partner::class)->findAll();
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $contact = $form->getData();
            if (empty($name)) {
                throw new BadRequestHttpException('name cannot be empty');
            }

            $email = $request->request->get('email');
            if (empty($email)) {
                throw new BadRequestHttpException('email cannot be empty');
            }
            $message = $request->request->get('message');
            if (empty($message)) {
                throw new BadRequestHttpException('message cannot be empty');
            }
            $subscribed = $request->request->get('subscribed');

            $contact->setName($name);
            $contact->setEmail($email);
            $contact->setMessage($message);
            $contact->setSubscribed($subscribed);

            // Create the message
            $letter = (new \Swift_Message())

                // Give the message a subject
                ->setSubject($email)

                // Set the From address with an associative array
                ->setFrom([$email => $name])

                // Set the To addresses with an associative array (setTo/setCc/setBcc)
                ->setTo(['ewahaaglanden@rocmondriaan.nl' => 'Ewa Haaglanden'])

                // Give it a body
                ->setBody($message);

            $mailer->send($letter);

            $this->em->persist($contact);
            $this->em->flush();
        }


            return $this->render('bezoeker/home.html.twig', [
                'form' => $form->createView(),
                'nieuwsberichten' => $nieuwsberichten,
                'partners'=>$partners
            ]);

    }
    /**
     * @Route("/showNieuwsdetail/{id}", name="showNieuwsdetail")
     */
    function showNieuwsDetailsAction(Request $request, $id)
    {
        $nieuwsbericht = $this->em->getRepository(Post::class)->find($id);
        return $this->render('bezoeker/showNieuwsbericht.html.twig', [
            'nieuwsbericht' => $nieuwsbericht,
        ]);

    }
    /**
     * @Route("/showNieuws", name="showNieuws")
     */
    public function findAllNbAction()
    {
        $news = $this->em->getRepository(Post::class)->findBy([], ['id' => 'DESC']);
        foreach($news as $nw)
        {
            $nw->setContent(substr($nw->getContent(),0,200));
            $nw->setContent($nw->getContent() . "...");
        }

        return $this->render('bezoeker/showNieuwsberichten.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/showPartners", name="showPartners")
     */
    public function findAllPAction()
    {
        $partners = $this->em->getRepository(Partner::class)->findBy([], ['id' => 'DESC']);

        return $this->render('bezoeker/showPartners.html.twig', [
            'partners' => $partners,
        ]);
    }
    /**
     * @Route("/showInformatie", name="showInformatie")
     */
    public function findAllIAction()
    {
        $information = $this->em->getRepository(Document::class)->findBy([], ['id' => 'DESC']);

        return $this->render('bezoeker/showInformatie.html.twig', [
            'informatietotaal' => $information,
        ]);
    }
}