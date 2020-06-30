<?php

namespace App\Controller;

use App\Entity\Participant;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ParticipantType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/participant", name="participant")
     * @param Request $request
     * @param SessionInterface $session
     * @return Response
     */
    public function participant(Request $request, SessionInterface $session)
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participant->setSession($session->getSession());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participant);
            $entityManager->flush();
            return $this->redirectToRoute('evaluation');
        }

        return $this->render('Form/participant.html.twig', [
            'participant' => $participant,
            'form' => $form->createView()
        ]);
    }
}
