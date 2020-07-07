<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Response;
use App\Entity\ResponseQcm;
use App\Repository\QuestionRepository;
use App\Repository\ResponseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class QcmController extends AbstractController
{
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $sessionParticipant)
    {
        $this->session = $sessionParticipant;
    }

    /**
     * @Route("/qcm-1", name="qcm_1", methods={"GET", "POST"})
     */
    public function qcm_1(QuestionRepository $questionRepository, ResponseRepository $responseRepository)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['response'])){
                $entityManager = $this->getDoctrine()->getManager();
                $responseQcm = new ResponseQcm();
                $response = $entityManager->getRepository(Response::class)->findBy(['number' => $_POST['response']]);
                $responseQcm->setResponse($response[0]);
                $participantId = $this->session->get('id');
                $repository = $this->getDoctrine()->getRepository(Participant::class);
                $participant = $repository->findBy(['id' => $participantId]);
                $responseQcm->setParticipant($participant[0]);
                $entityManager->persist($responseQcm);
                $entityManager->flush();

                $result = null;
                if ($_POST['response'] == 2){
                    $result = true;
                } else {
                    $result = false;
                }

                return $this->render('response/index.html.twig', [
                    'result' => $result,
                    'question' => $questionRepository->findOneById(1),
                    'responses' => $responseRepository->findAll(),
                    ]);

            } else {
                $error = 'Veuillez sélectionner une réponse';
                return $this->render('response/index.html.twig', [
                    'question' => $questionRepository->findOneById(1),
                    'responses' => $responseRepository->findAll(),
                    'error' => $error
                ]);
            }
        }

        return $this->render('response/index.html.twig', [
            'question' => $questionRepository->findOneById(1),
            'responses' => $responseRepository->findAll(),
        ]);

    }

    /**
     * @Route("/qcm-2", name="qcm_2", methods={"GET", "POST"})
     */
    public function qcm_2(QuestionRepository $questionRepository, ResponseRepository $responseRepository)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['response'])){
            $entityManager = $this->getDoctrine()->getManager();
            $responseQcm = new ResponseQcm();
            $response = $entityManager->getRepository(Response::class)->findBy(['number' => $_POST['response']]);
            $responseQcm->setResponse($response[0]);
            $participantId = $this->session->get('id');
            $repository = $this->getDoctrine()->getRepository(Participant::class);
            $participant = $repository->findBy(['id' => $participantId]);
            $responseQcm->setParticipant($participant[0]);
            $entityManager->persist($responseQcm);
            $entityManager->flush();

            $result = null;
            if ($_POST['response'] == 4){
                $result = true;
            } else {
                $result = false;
            }

            return $this->render('response/qcm2.html.twig', [
                'result' => $result,
                'question' => $questionRepository->findOneById(2),
                'responses' => $responseRepository->findAll(),
            ]);

        } else {
            $error = 'Veuillez sélectionner une réponse';
            return $this->render('response/index.html.twig', [
                'question' => $questionRepository->findOneById(2),
                'responses' => $responseRepository->findAll(),
                'error' => $error
            ]);
        }
    }

        return $this->render('response/qcm2.html.twig', [
            'question' => $questionRepository->findOneById(2),
            'responses' => $responseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/qcm-3", name="qcm_3", methods={"GET", "POST"})
     */
    public function qcm_3(QuestionRepository $questionRepository, ResponseRepository $responseRepository)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['response'])) {
                $entityManager = $this->getDoctrine()->getManager();
                $responseQcm = new ResponseQcm();
                $response = $entityManager->getRepository(Response::class)->findBy(['number' => $_POST['response']]);
                $responseQcm->setResponse($response[0]);
                $participantId = $this->session->get('id');
                $repository = $this->getDoctrine()->getRepository(Participant::class);
                $participant = $repository->findBy(['id' => $participantId]);
                $responseQcm->setParticipant($participant[0]);
                $entityManager->persist($responseQcm);
                $entityManager->flush();

                $result = null;
                if ($_POST['response'] == 8) {
                    $result = true;
                } else {
                    $result = false;
                }
            } else {
                $error = 'Veuillez sélectionner une réponse';
                return $this->render('response/index.html.twig', [
                    'question' => $questionRepository->findOneById(3),
                    'responses' => $responseRepository->findAll(),
                    'error' => $error
                ]);
            }

            return $this->render('response/qcm3.html.twig', [
                'result' => $result,
                'question' => $questionRepository->findOneById(3),
                'responses' => $responseRepository->findAll(),
            ]);
        }

        return $this->render('response/qcm3.html.twig', [
            'question' => $questionRepository->findOneById(3),
            'responses' => $responseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/qcmEnd", name="qcm_end", methods={"GET", "POST"})
     */
    public function qcmEnd()
    {
        return $this->render('response/qcmEnd.html.twig');
    }

}