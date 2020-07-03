<?php

namespace App\Controller;

use App\Entity\ResponseQcm;
use App\Entity\Session;
use App\Entity\User;
use App\Repository\QuestionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

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
     * @Route(path = "/qcm_list", name = "qcm_list")
     * @param Request $request
     * @return Response
     */
    public function getQcmList(Request $request, QuestionRepository $question)
    {
        $repository = $this->getDoctrine()->getRepository(Session::class);
        //$id = $request->query->get('id');
        $session = $repository->find(2);
        $participants = $session->getParticipants();
        $company = $session->getCompany();
        $training = $session->getTraining();
        $questions = $question->findAll();

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('pdf/qcmList.html.twig', [
            'company' => $company,
            'participants' => $participants,
            'training' => $training,
            'questions' => $questions
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $output = $dompdf->output();
        $pdfFilepath = 'assets/documents/qcm/qcm_'.$company->getName().'_session'.$session->getId().'.pdf';
        file_put_contents($pdfFilepath, $output);

        return $this->render('pdf/qcmList.html.twig', [
            'participants' => $participants,
            'company' => $company,
            'training' => $training,
            'questions' => $questions
        ]);
    }
}