<?php

namespace App\EventListener;

use App\Util\ArrayUtil;
use DateTime;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\FirewallMapInterface;

class ResponseListener implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
        private FirewallMapInterface $firewallMap,
        private int $sessionLifetimeInSeconds,
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => ['onResponse', -8],
        ];
    }

    /**
     * @throws AccessDeniedException
     */
    public function onResponse(ResponseEvent $event): void
    {
        $firewallConfig = $this->firewallMap->getFirewallConfig($event->getRequest());
        if (null === $firewallConfig) {
            return;
        }
        
        $firewallName = $firewallConfig->getName();
        if ($firewallName !== 'main') {
            return;
        }

        $lifetime = ($this->security->getUser()) 
            ? (time() + $this->sessionLifetimeInSeconds) 
            : 0;

        // This is how frontend knows when user session expires and when to forbid logged only sites
        $this->setResponseCookie($event, 'SESSION-EXPIRY', $lifetime);
    }

    private function setResponseCookie(ResponseEvent $event, string $name, int $lifetime): void
    {
        $cookie = new Cookie(
            name: $name, 
            value: $lifetime, 
            expire: time() + 10000 + $lifetime, 
            path: '/', 
            domain: null, 
            secure: false, 
            httpOnly: false, 
            raw: false, 
            sameSite: 'strict'
        );
        $event->getResponse()->headers->setCookie($cookie);
    }

    private function getCookieExpiry(ResponseEvent $event, string $cookieName): ?int
    {
        $cookies = ArrayUtil::flatten($event->getResponse()->headers->getCookies());
        foreach ($cookies as $cookie) {
            if ($cookie->getName() === $cookieName) {
                return $cookie->getExpiresTime();
            }
        }

        return null;
    }
}