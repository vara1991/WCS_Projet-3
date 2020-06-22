<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\User;
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
     * @Security("has_role('ROLE_ADMIN')")
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
}