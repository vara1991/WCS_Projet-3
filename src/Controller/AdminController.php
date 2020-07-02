<?php

namespace App\Controller;


use App\Entity\Session;
use App\Entity\User;
use App\Repository\EvalQuestionRepository;
use App\Repository\EvaluationRepository;
use App\Repository\ResponseYnRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route(path = "/admin/admin/register", name = "session_register")
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Request $request
     * @return Response
     */

    public function registerAction(UserPasswordEncoderInterface $passwordEncoder, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Session::class);
        $id = $request->query->get('id');
        $entity = $repository->find($id);

        $user = new User();
        $user->setRoles(['ROLE_SUBSCRIBER']);
        $user->setEmail($entity->getCompany()->getEmail());
        $user->setSession($entity);
        $user->setPassword($entity->getPassword());
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $entity->getPassword()
            )
        );
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('easyadmin');
    }

    /**
     * @Route("/evaluation/{id}", name="evaluation_pdf")
     */
    public function generateEvalaution(Session $session,EvalQuestionRepository $questionsRepository, EvaluationRepository $evaluationRepository, ResponseYnRepository $responseYnRepository): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $training = $session->getTraining();
        $html = $this->renderView('pdf/evaluation.html.twig',[
            'questions' => $questionsRepository->findall(),
            'training' =>  $training,
            'evaluations' => $training->getEvaluations(),
            'company' => $session->getCompany(),
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $output = $dompdf->output();
        $pdfFilepath = 'assets/documents/evaluation/evaluation'.$session->getCompany()->getName().$session->getId().'.pdf';
        file_put_contents($pdfFilepath, $output);

        return $this->render('pdf/evaluation.html.twig',[
            'questions' => $questionsRepository->findall(),
            'evaluations' => $session->getTraining()->getEvaluations(),
            'training' =>  $training,
            'company' => $session->getCompany(),
        ]);
    }
}