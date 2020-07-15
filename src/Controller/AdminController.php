<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use App\Entity\Participant;
use App\Entity\Session;
use App\Entity\User;
use App\Repository\EvalQuestionRepository;
use App\Repository\EvaluationRepository;
use App\Repository\ResponseYnRepository;
use App\Repository\UserRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Filesystem\Filesystem;

class AdminController extends AbstractController
{
    /**
     * @Route(path = "/admin/admin/register/{id}", name = "session_register")
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Session $session
     * @return Response
     */
    public function registerAction(UserPasswordEncoderInterface $passwordEncoder, Session $session): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_SUBSCRIBER']);
        $user->setEmail($session->getCompany()->getEmail());
        $user->setSession($session);
        $user->setPassword($session->getPassword());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash('success', 'La connexion a bien été créée, l\'entreprise peut se connecter avec le mot de passe à 4 chiffres créé dans session ! ');

        return $this->redirectToRoute('easyadmin', ['action' => 'list', 'entity' => 'Session']);
    }

    /**
     * @Route(path = "/qcm_list", name = "qcm_list")
     * @param Request $request
     * @param QuestionRepository $question
     * @return Response
     */
    public function getQcmList(Request $request, QuestionRepository $question)
    {
        $repository = $this->getDoctrine()->getRepository(Session::class);
        $id = $request->query->get('id');
        $session = $repository->find($id);

        $pdfQCM = 'assets/documents/qcm/qcm_'.$session->getCompany()->getName().'_session'.$session->getId().'.pdf';

        return $this->render('pdf/qcmListPdfView.html.twig', [
            'qcmList' => $pdfQCM,
        ]);
    }

    /**
     * @Route("/evaluation_pdf", name="evaluation_pdf")
     * @param Request $request
     * @return Response
     */
    public function pdfEvalaution(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Session::class);
        $id = $request->query->get('id');
        $session = $repository->find($id);

        $pdfEvaluation = 'assets/documents/evaluation/evaluation'.$session->getCompany()->getName().$session->getId().'.pdf';

        return $this->render('pdf/evaluationPdfView.html.twig',[
            'evaluation' => $pdfEvaluation,
        ]);
    }
          
    /**
     * @Route(path = "/attestation", name = "attestation")
     * @param Request $request
     * @return Response
     */
    public function getAttestation(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Participant::class);
        $id = $request->query->get('id');
        $participant = $repository->find($id);

        $attestation = 'assets/documents/attestations/attestation'.$participant->getFirstname().$participant->getLastname().$participant->getId().'.pdf';

        return $this->render('pdf/attestationPdfView.html.twig', [
            'attestation' => $attestation
        ]);
    }

    /**
     * @Route(path = "/archived/{id}", name = "archived")
     * @param Session $session
     * @param QuestionRepository $question
     * @param EvalQuestionRepository $questionsRepository
     * @param MailerInterface $mailer
     * @param UserRepository $userRepository
     * @throws TransportExceptionInterface
     * @return Response
     */
    public function archived(Session $session, QuestionRepository $question,  EvalQuestionRepository $questionsRepository, MailerInterface $mailer, UserRepository $userRepository):Response
    {
        $filesystem = new Filesystem();
        $participants = $session->getParticipants();
        $company = $session->getCompany();
        $training = $session->getTraining();
        $questions = $question->findAll();
        // PDF QCM list
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
        $pdfFilepath = 'assets/documents/qcm/qcm_' . $company->getName() . '_session' . $session->getId() . '.pdf';
        file_put_contents($pdfFilepath, $output);
        // PDF Evaluation list
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $training = $session->getTraining();
        $html = $this->renderView('pdf/evaluation.html.twig', [
            'questions' => $questionsRepository->findall(),
            'training' => $training,
            'evaluations' => $training->getEvaluations(),
            'company' => $session->getCompany(),
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $output = $dompdf->output();
        $pdfFilepath = 'assets/documents/evaluation/evaluation' . $session->getCompany()->getName() . $session->getId() . '.pdf';
        file_put_contents($pdfFilepath, $output);

        $email = (new TemplatedEmail())
            ->from('sten.test4php@gmail.com')
            ->to('sten.test4php@gmail.com')
            ->subject('Avis et QCM de formation LUF/SCHILLER')
            ->htmlTemplate('Home/email/avis-qcm.html.twig')
            ->context(['contact' => $session])
            ->attachFromPath('assets/documents/evaluation/evaluation' . $session->getCompany()->getName() . $session->getId() . '.pdf')
            ->attachFromPath('assets/documents/qcm/qcm_' . $session->getCompany()->getName() . '_session' . $session->getId() . '.pdf');
        $mailer->send($email);

        $em = $this->getDoctrine()->getManager();
        foreach ($participants as $participant) {
            $filesystem->remove(['assets/documents/attestations/attestation'.$participant->getFirstname().$participant->getLastname().$participant->getId().'.pdf']);
            $participant->setFirstname('XXX');
            $participant->setLastname('XXX');
            $participant->setEmail('xxx@xxx.xxx');
            $participant->setIsArchived(true);
            $em->persist($participant);
        }
        $user = $userRepository->findOneBy(['id' => $session->getUser()]);
        $session->setUser(null);
        $session->setIsArchived(true);
        $em->remove($user);

        $em->flush();
        $this->addFlash('success', 'La session a bien été archivée et un email avec les avis et les réponses au QCM a bien été envoyé à l\'entreprise ainsi qu\'à vous !');

        return $this->redirectToRoute('easyadmin', ['action' => 'list', 'entity' => 'Session']);
    }
}