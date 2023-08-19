<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Tester;
use App\Entity\Developer;
use App\Entity\ProjectManager;
use App\Form\TesterFormType;
use App\Form\DeveloperFormType;
use App\Form\ProjectManagerFormType;
use App\Traits\EntityManagerTrait;
use App\Repository\UserRepository;
use App\Exception\ApiException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Messenger\Command\SetAndSendCredentialsEmailCommand;

/**
 * Exceptions are handled by ApiExceptionHandler.
 */
#[Route('/api/user')]
class UserController extends AbstractController
{
    use EntityManagerTrait;

    public function __construct(
        private UserRepository $userRepository,
        private ValidatorInterface $validator,
        private MessageBusInterface $commandBus,
    ) {}

    #[Route('/', name: 'api_user_index', methods: 'GET')]
    public function index(): JsonResponse
    {
        return $this->json($this->userRepository->findWithoutRole('ROLE_ADMIN'));
    }

    #[Route('/', name: 'api_user_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = $request->request->all();
        $userClass = User::JOB_SUBCLASS_MAP[$data['job'] ?? null];
        if (!$userClass) {
            throw new BadRequestException();
        }
        $user = new $userClass();
        $form = $this->createFormForUser($user);
        if (!$form) {
            throw new BadRequestException();
        }
        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // For explanation why we not set login and password yet, see documentation in command 
            // App\Messenger\Command\SetAndSendCredentialsEmailCommand
            $this->commandBus->dispatch(new SetAndSendCredentialsEmailCommand((string) $user->getId()));

            return $this->json($user);
        }

        $this->throwApiExceptionWithErrors($form);
    }

    #[Route('/{id}', name: 'api_user_update', methods: 'POST')]
    #[ParamConverter('user', class: User::class)]
    public function update(User $user, Request $request): JsonResponse
    {
        $this->entityManager->beginTransaction();
        try {
            $job = $request->request->all()['job'] ?? null;
            if (!$job) {
                throw new \Exception("Missing 'job' key.");
            }
            $newUserClass = User::JOB_SUBCLASS_MAP[$job];
            if (!$newUserClass) {
                throw new \Exception("Missing 'job' key.");
            }
            if (!($user instanceof $newUserClass)) {
                $this->userRepository->changeJob($user, $job, false);
            }

            $user = $this->userRepository->find($user->getId());
            $form = $this->createFormForUser($user);
            if (!$form) {
                throw new BadRequestException();
            }
            
            $form->submit($request->request->all());

            if ($form->isSubmitted() && $form->isValid()) {
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $this->entityManager->commit();

                return $this->json($user);
            }

            $this->throwApiExceptionWithErrors($form);
        } catch (Exception $e) {
            if ($this->entityManager->getConnection()->getTransactionNestingLevel() > 0) {
                $this->entityManager->rollBack();
            }

            throw $e;
        }
    }

    #[Route('/{id}', name: 'api_user_delete', methods: 'DELETE')]
    #[ParamConverter('user', class: User::class)]
    public function delete(User $user, Request $request): JsonResponse
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RegistrationController.php',
        ]);
    }

    /**
     * @throws ApiException
     */
    private function throwApiExceptionWithErrors(FormInterface $form): never
    {
        $errors = [];
        foreach ($form->all() as $property => $form) {
            $error = ($form->getErrors()[0] ?? null)?->getMessage();
            if ($error) {
                $errors[$property] = $error;
            }
        }

        throw new ApiException(code: 400, data: $errors);
    }

    /**
     * @throws BadRequestException
     */
    private function createFormForUser(User $user): ?FormInterface
    {
        $formClass = match(get_class($user)) {
            Tester::class => TesterFormType::class,
            Developer::class => DeveloperFormType::class,
            ProjectManager::class => ProjectManagerFormType::class,
        };
        
        return $formClass ? $this->createForm($formClass, $user) : null;
    }
}
