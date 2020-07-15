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
        $connection = false;
        if ($this->session->get('connection') == true){
            $connection = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['response'])){
                $entityManager = $this->getDoctrine()->getManager();
                $responseQcm = new ResponseQcm();
                $response = $entityManager->getRepository(Response::class)->findOneBy(['number' => $_POST['response']]);
                $responseQcm->setResponse($response);
                $participantId = $this->session->get('id');
                $repository = $this->getDoctrine()->getRepository(Participant::class);
                $participant = $repository->findOneBy(['id' => $participantId]);
                $responseQcm->setParticipant($participant);
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
                    'questions' => $questionRepository->findAll(),
                    'responses' => $responseRepository->findAll(),
                    'connection' => $connection
                    ]);

            } else {
                $error = 'Veuillez sélectionner une réponse';
                return $this->render('response/index.html.twig', [
                    'questions' => $questionRepository->findAll(),
                    'responses' => $responseRepository->findAll(),
                    'error' => $error,
                    'connection' => $connection
                ]);
            }
        }

        return $this->render('response/index.html.twig', [
            'questions' => $questionRepository->findAll(),
            'responses' => $responseRepository->findAll(),
            'connection' => $connection
        ]);

    }

    /**
     * @Route("/qcm-2", name="qcm_2", methods={"GET", "POST"})
     */
    public function qcm_2(QuestionRepository $questionRepository, ResponseRepository $responseRepository)
    {
        $connection = false;
        if ($this->session->get('connection') == true){
            $connection = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['response'])){
            $entityManager = $this->getDoctrine()->getManager();
            $responseQcm = new ResponseQcm();
            $response = $entityManager->getRepository(Response::class)->findOneBy(['number' => $_POST['response']]);
            $responseQcm->setResponse($response);
            $participantId = $this->session->get('id');
            $repository = $this->getDoctrine()->getRepository(Participant::class);
            $participant = $repository->findOneBy(['id' => $participantId]);
            $responseQcm->setParticipant($participant);
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
                'questions' => $questionRepository->findAll(),
                'responses' => $responseRepository->findAll(),
                'connection' => $connection,
            ]);

        } else {
            $error = 'Veuillez sélectionner une réponse';
            return $this->render('response/qcm2.html.twig', [
                'questions' => $questionRepository->findAll(),
                'responses' => $responseRepository->findAll(),
                'error' => $error,
                'connection' => $connection
            ]);
        }
    }

        return $this->render('response/qcm2.html.twig', [
            'questions' => $questionRepository->findAll(),
            'responses' => $responseRepository->findAll(),
            'connection' => $connection
        ]);
    }

    /**
     * @Route("/qcm-3", name="qcm_3", methods={"GET", "POST"})
     */
    public function qcm_3(QuestionRepository $questionRepository, ResponseRepository $responseRepository)
    {
        $connection = false;
        if ($this->session->get('connection') == true){
            $connection = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['response'])) {
                $entityManager = $this->getDoctrine()->getManager();
                $responseQcm = new ResponseQcm();
                $response = $entityManager->getRepository(Response::class)->findOneBy(['number' => $_POST['response']]);
                $responseQcm->setResponse($response);
                $participantId = $this->session->get('id');
                $repository = $this->getDoctrine()->getRepository(Participant::class);
                $participant = $repository->findOneBy(['id' => $participantId]);
                $responseQcm->setParticipant($participant);
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
                return $this->render('response/qcm3.html.twig', [
                    'questions' => $questionRepository->findAll(),
                    'responses' => $responseRepository->findAll(),
                    'error' => $error,
                    'connection' => $connection
                ]);
            }

            return $this->render('response/qcm3.html.twig', [
                'result' => $result,
                'questions' => $questionRepository->findAll(),
                'responses' => $responseRepository->findAll(),
                'connection' => $connection
            ]);
        }

        return $this->render('response/qcm3.html.twig', [
            'questions' => $questionRepository->findAll(),
            'responses' => $responseRepository->findAll(),
            'connection' => $connection
        ]);
    }

    /**
     * @Route("/qcmEnd", name="qcm_end", methods={"GET", "POST"})
     */
    public function qcmEnd()
    {
        $connection = false;
        if ($this->session->get('connection') == true){
            $connection = true;
        }

        return $this->render('response/qcmEnd.html.twig',[
            'connection' => $connection
        ]);
    }

}