<?php

namespace App\Controller;

use App\Entity\EvalScore;
use App\Entity\Evaluation;
use App\Entity\EvalYn;
use App\Entity\ResponseScore;
use App\Entity\ResponseYn;
use App\Repository\EvalQuestionRepository;
use App\Repository\EvalScoreRepository;
use App\Repository\EvalYnRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class EvaluationController extends AbstractController
{
    /**
     * @Route("/evaluation", name="evaluation")
     */
    public function index(Request $request, EvalQuestionRepository $questionsRepository, EvalYnRepository $evalYnRepository, EvalScoreRepository $evalScoreRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $evaluation = new Evaluation();
        $evaluation->setCreatedAt(new \DateTime('now'));
        $evaluation->setCompany($this->getUser()->getSession()->getCompany());
        $evaluation->setTraining($this->getUser()->getSession()->getTraining());

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
                $YN = $em->getRepository(EvalYN::class)->findBy(['id' => $_POST['responseYN'.$i]]);
                $responseYn->setEvalYn($YN[0]);
                $em->persist($responseYn);
            }

            for ($i=1; $i<=6; $i++){
                $responseScore = new ResponseScore();
                $responseScore->setEvaluation($evaluation);
                $score = $em->getRepository(EvalScore::class)->findBy(['id' => $_POST['responseScore'.$i]]);
                $responseScore->setEvalScore($score[0]);
                $em->persist($responseScore);
            }
            $em->flush();

            return $this->redirectToRoute('qcm_1');
        }

        return $this->render('evaluation/index.html.twig', [
            'evalYn' => $evalYnRepository->findAll(),
            'evalScore' => $evalScoreRepository->findAll(),
            'questions' => $questionsRepository->findall(),
            'company' => $this->getUser()->getSession()->getCompany()->getName(),
            'trainingDate' => $this->getUser()->getSession()->getTraining()->getFaceDate(),
            'trainingName' => $this->getUser()->getSession()->getTraining()->getTitle(),
        ]);
    }
}
