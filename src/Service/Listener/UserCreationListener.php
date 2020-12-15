<?php


namespace App\Service\Listener;


use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserCreationListener
{
    private $mailer;

    private $urlGenerator;

    /**
     * UserCreationListener constructor.
     * @param MailerInterface $mailer
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(MailerInterface $mailer, UrlGeneratorInterface $urlGenerator)
    {
        $this->mailer = $mailer;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param User $user
     * @throws TransportExceptionInterface
     */
    public function validateEmail(User $user) {
        $email = (new TemplatedEmail())
            ->from('student@bes-webdeveloper-seraing.be')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Activate your account')
            ->text('please follow this link ' . $this->urlGenerator->generate('activateAccount', ['key' => $user->getTempSecretKey()]))
            ->htmlTemplate('email/activate-account.html.twig')
            ->context([
                'user' => $user
            ])
        ;

        $this->mailer->send($email);
    }
}