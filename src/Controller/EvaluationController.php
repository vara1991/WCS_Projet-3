<?php

namespace App\Controller;

use App\Entity\EvalScore;
use App\Entity\Evaluation;
use App\Entity\EvalYn;
use App\Entity\User;
use App\Entity\ResponseScore;
use App\Entity\ResponseYn;
use App\Repository\EvalQuestionRepository;
use App\Repository\EvalScoreRepository;
use App\Repository\EvalYnRepository;
use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class EvaluationController extends AbstractController
{
    /**
     * @var SessionInterface
     */
    private $session;
    private $participantRepository;

    public function __construct(ParticipantRepository $participantRepository, SessionInterface $sessionParticipant)
    {
        $this->participantRepository = $participantRepository;
        $this->session = $sessionParticipant;
    }

    /**
     * @Route("/evaluation/{id}", name="evaluation")
     */
    public function index(Request $request, User $user, EvalQuestionRepository $questionsRepository, EvalYnRepository $evalYnRepository, EvalScoreRepository $evalScoreRepository)
    {
        $connection = false;
        if ($this->session->get('connection') == true){
            $connection = true;
        }

        $em = $this->getDoctrine()->getManager();
        $evaluation = new Evaluation();
        $evaluation->setCreatedAt(new \DateTime('now'));
        $evaluation->setCompany($user->getSession()->getCompany());
        $evaluation->setTraining($user->getSession()->getTraining());

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $evaluation->setName($_POST['name']);
            $evaluation->setGlobalScore($_POST['global_score']);
            if(isset($_POST['comment'])){
                $evaluation->setComment($_POST['comment']);
            };
            $em->persist($evaluation);

            for ($i=1 ; $i<=4; $i++){
                $responseYn = new ResponseYn();
                $responseYn->setEvaluation($evaluation);
                $YN = $em->getRepository(EvalYN::class)->findOneBy(['id' => $_POST['responseYN'.$i]]);
                $responseYn->setEvalYn($YN);
                $em->persist($responseYn);
            }

            for ($i=1; $i<=6; $i++){
                $responseScore = new ResponseScore();
                $responseScore->setEvaluation($evaluation);
                $score = $em->getRepository(EvalScore::class)->findOneBy(['id' => $_POST['responseScore'.$i]]);
                $responseScore->setEvalScore($score);
                $em->persist($responseScore);
            }
            $em->flush();

            return $this->redirectToRoute('qcm_1');
        }

        return $this->render('evaluation/index.html.twig', [
            'participant' => $this->participantRepository->findOneBy(['id' => $this->session->get('id')]),
            'evalYn' => $evalYnRepository->findAll(),
            'evalScore' => $evalScoreRepository->findAll(),
            'questions' => $questionsRepository->findall(),
            'company' => $user->getSession()->getCompany()->getName(),
            'trainingDate' => $user->getSession()->getTraining()->getFaceDate(),
            'trainingName' => $user->getSession()->getTraining()->getTitle(),
            'connection' => $connection
        ]);
    }
}
