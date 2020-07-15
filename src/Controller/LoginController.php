<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class LoginController extends AbstractController
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
     * @Route("/login", name="login")
     */
    public function index(UserRepository $userRepository, SessionRepository $sessionRepository)
    {
        $error = null;
        $connection = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (!empty($_POST['password'])) {
                if ($userRepository->findBy(['password' => $_POST['password']])){
                    $user = $userRepository->findOneBy(['password' => $_POST['password']]);
                    $connection = true;
                    $this->session->set('connection', $connection);
                    return $this->redirectToRoute('participant',[
                        'id' => $user->getId()
                    ]);
                }else{
                    $error = 'Le mot de passe est incorrect';
                }
            } else {
                $error = 'Le mot de passe est obligatoire';
            }
        }

        return $this->render('login/index.html.twig', [
            'error' => $error,
            'connection' => $connection
        ]);
    }
}
