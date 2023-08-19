<?php

namespace App\EventListener;

use App\Traits\TranslatorTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Exception\ApiException;

class ApiExceptionHandler implements EventSubscriberInterface
{
    use TranslatorTrait;

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'handleException',
        ];
    }

    public function handleException(ExceptionEvent $event): void
    {
        if (!str_starts_with($event->getRequest()->getRequestUri(), '/api')) {
            return;
        }
        
        $e = $event->getThrowable();

        if ($e instanceof ApiException) {
            $response = new JsonResponse($e->presentData(), $e->getCode());
        } elseif ($e instanceof HttpExceptionInterface) {
            $message = $this->getDisplayedError($e->getMessage(), $e->getStatusCode());
            $response = new JsonResponse(['error' => $message], $e->getStatusCode(), $e->getHeaders());
        } else {
            $response = new JsonResponse([
                'error' => $this->getDisplayedError($e->getMessage(), 500)
            ], 500);
        }
        
        $event->setResponse($response);
    }

    private function getDisplayedError(string $originalMessage, int $statusCode): string
    {
        return ($_ENV['APP_ENV'] === 'dev') 
            ? $originalMessage 
            : $this->translator->trans("common.http.error_$statusCode");
    }
}