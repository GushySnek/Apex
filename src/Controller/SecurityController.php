<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Form\ResetPasswordType;
use App\Form\UserPasswordType;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use App\Security\ResetPasswordModel;
use App\Security\ResetPasswordService;
use App\Service\ImageUploader;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param ImageUploader $imageUploader
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, ImageUploader $imageUploader) {
        $user = new User();
        $user->setRoles(['ROLE_USER'])
            ->setActive(false)
            ->setSecretKeyDate(new DateTime())
            ->setTempSecretKey(bin2hex(random_bytes(10)))
        ;

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageUploader->uploadOneFileFromForm($form);
            $user->setPassword($userPasswordEncoder->encodePassword($user, $user->getPlainPassword()))
                ->eraseCredentials()
            ;

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('registerWaitingValidation');
        }

        return $this->render('page/profile-create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/register-waiting-validation", name="registerWaitingValidation")
     * @return Response
     */
    public function registerWaitingValidation() {
        return $this->render('security/register-waiting-validation.html.twig');
    }

    /**
     * @param string $key
     * @param UserRepository $repository
     * @param EntityManagerInterface $entityManager
     * @param GuardAuthenticatorHandler $guardAuthenticatorHandler
     * @param Request $request
     * @param LoginFormAuthenticator $authenticator
     * @return Response|null
     * @Route("/activate/{key}", name="activateAccount")
     */
    public function activateAccount(string $key, UserRepository $repository, EntityManagerInterface $entityManager, GuardAuthenticatorHandler $guardAuthenticatorHandler, Request $request, LoginFormAuthenticator $authenticator) {
        $user = $repository->findOneBy(['tempSecretKey' => $key]);

        if ($user !== null) {
            $user->setActive(true)
                ->setTempSecretKey(null)
                ->setSecretKeyDate(null);

            $entityManager->flush();
        }

        return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $authenticator,
            'main' // firewall name in security.yaml
        );
    }

    /**
     * @Route("/reset-password", name="resetPassword")
     * @param Request $request
     * @param ResetPasswordService $resetPasswordService
     * @return RedirectResponse|Response
     */
    public function resetPasswordQuery(Request $request, ResetPasswordService $resetPasswordService) {
        $resetPasswordData = new ResetPasswordModel();
        $form = $this->createForm(ResetPasswordType::class, $resetPasswordData);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $resetPasswordService->startResetPasswordByEmail($resetPasswordData->getEmail());
            return $this->redirectToRoute('resetPasswordWaiting');
        }
        return $this->render("security/reset-password.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("/reset-password/waiting", name="resetPasswordWaiting")
     */
    public function resetPasswordWaiting() {
        return $this->render("security/reset-password-waiting.html.twig");
    }

    /**
     * @Route("/reset-password/{token}", name="resetPasswordToken")
     * @param string $token
     * @param UserRepository $userRepository
     * @param GuardAuthenticatorHandler $guardAuthenticatorHandler
     * @param Request $request
     * @param LoginFormAuthenticator $authenticator
     * @param ResetPasswordService $resetPasswordService
     * @return Response|null
     */
    public function resetPasswordToken(string $token,UserRepository $userRepository, GuardAuthenticatorHandler $guardAuthenticatorHandler, Request $request, LoginFormAuthenticator $authenticator, ResetPasswordService $resetPasswordService) {
        $user = $userRepository->findOneBy(['tempSecretKey' => $token]);
        if ($user === null) {
            throw new NotFoundHttpException();
        }
        $valid = false;
        if ($resetPasswordService->isResetValid($user)) {
            $valid = true;
            $form = $this->createForm(UserPasswordType::class, $user);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $resetPasswordService->savePassword($user);

                return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $authenticator,
                    'main' // firewall name in security.yaml
                );
            }
        }

        return $this->render("/security/reset-password-token.html.twig", ['valid' => $valid, 'form' => $form->createView()]);
    }
}
