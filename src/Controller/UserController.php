<?php


namespace App\Controller;


use App\Form\UserPasswordType;
use App\Form\UserType;
use App\Security\ResetPasswordService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/my-account", name="myAccount")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function myAccount(EntityManagerInterface $entityManager, Request $request) {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', "Your email has been updated");
        }

        return $this->render("security/my-account.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("/my-password", name="myPassword")
     * @param Request $request
     * @param ResetPasswordService $resetPasswordService
     * @return Response
     */
    public function myPassword(Request $request, ResetPasswordService $resetPasswordService) {
        $user = $this->getUser();

        $form = $this->createForm(UserPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $resetPasswordService->savePassword($user);
        }

        return $this->render("security/my-account.html.twig", ['formPassword' => $form->createView()]);
    }
}