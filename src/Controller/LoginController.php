<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class LoginController extends AbstractController
{
    // The SessionInterface save the participant in global var session
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $sessionParticipant)
    {
        $this->session = $sessionParticipant;
    }

    //this function put the connection->true for the participant if it's the good the password
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
