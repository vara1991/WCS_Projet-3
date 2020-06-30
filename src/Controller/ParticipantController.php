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
     * @return Response
     */
    public function participant(Request $request)
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
            return $this->redirectToRoute('evaluation');
        }

        return $this->render('Form/participant.html.twig', [
            'participant' => $participant,
            'form' => $form->createView()
        ]);
    }
}
