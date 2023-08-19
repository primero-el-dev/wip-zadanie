<?php

namespace App\Messenger\Command\Handler;

use App\Messenger\Command\Handler\CommandHandlerInterface;
use App\Messenger\Command\SetAndSendCredentialsEmailCommand;
use App\Repository\UserRepository;
use App\Util\StringUtil;
use App\Traits\EntityManagerTrait;
use App\Traits\TranslatorTrait;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SetAndSendCredentialsEmailCommandHandler implements CommandHandlerInterface, MessageHandlerInterface
{
	use EntityManagerTrait;
	use TranslatorTrait;

	public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
		private UserRepository $userRepository, 
		private MailerInterface $mailer,
	) {}

	public function __invoke(SetAndSendCredentialsEmailCommand $command): void
	{
		$user = $this->userRepository->find($command->userId);
		if (!$user) {
			return;
		}

        $user->setLogin((string) $user->getId());
        $login = (string) $user->getId();
        $plainPassword = StringUtil::getRandom(12);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setLogin($login)->setPassword($hashedPassword);
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();

		$email = (new TemplatedEmail())
            ->from(getenv('MAIL_FROM'))
            ->to($user->getEmail())
            ->subject($this->translator->trans('email.credentials_and_invitation_email.subject'))
            ->htmlTemplate('emails/credentials_and_invitation_email.html.twig')
            ->context([
		        'login' => $user->getLogin(),
		        'plainPassword' => $plainPassword,
		    ])
        ;

        $this->mailer->send($email);
	}
}