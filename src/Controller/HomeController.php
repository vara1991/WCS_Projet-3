<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('Home/index.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function contact(Request $request, MailerInterface $mailer) :Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
                ->from('sten.quidelleur@outlook.fr')
                ->to('sten.test4php@gmail.com')
                ->subject($contact->getObject())
                ->htmlTemplate('Home/email/notification.html.twig')
                ->context(['contact' => $contact]);
            $mailer->send($email);
            $this->addFlash('success', 'Votre mail a bien été envoyé !');

            return $this->redirectToRoute('home_index');
        }

        return $this->render('Home/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/memento", name="memento")
     * @return Response
     */
    public function memento(): Response
    {
        return $this->render('Home/email/memento.html.twig');
    }

    /**
     * @Route("/mentions-legales", name="mentions_legales")
     * @return Response
     */
    public function mentions_legales(): Response
    {
        return $this->render('Home/mentions_legales.html.twig');
    }
}