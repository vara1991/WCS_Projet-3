<?php

namespace App\Controller;

use App\Entity\Participant;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ParticipantType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/participant", name="participant")
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function participant(Request $request, MailerInterface $mailer):Response
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participant->setSession($this->getUser()->getSession());
            $participant->setCompany($this->getUser()->getSession()->getCompany());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participant);
            $entityManager->flush();

            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');
            $dompdf = new Dompdf($pdfOptions);
            $company = $this->getUser()->getSession()->getCompany();
            $training = $this->getUser()->getSession()->getTraining();
            $html = $this->renderView('pdf/attestation.html.twig', [
                'company' => $company,
                'participant' => $participant,
                'training' => $training
            ]);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $output = $dompdf->output();
            $pdfFilepath = 'assets/documents/attestations/attestation'.$participant->getFirstname().$participant->getLastname().'.pdf';
            file_put_contents($pdfFilepath, $output);

            $email = (new TemplatedEmail())
                ->from('sten.quidelleur@outlook.fr')
                ->to('sten.test4php@gmail.com')
                ->subject('Votre attestation de formation LUF/SCHILLER')
                ->htmlTemplate('Home/email/attestation-email.html.twig')
                ->context(['contact' => $participant])
                ->attachFromPath('assets/documents/attestations'.'/attestation'.$participant->getFirstname().$participant->getLastname().'.pdf');
            $mailer->send($email);

            return $this->redirectToRoute('evaluation');
        }

        return $this->render('Form/participant.html.twig', [
            'participant' => $participant,
            'form' => $form->createView()
        ]);
    }
}
