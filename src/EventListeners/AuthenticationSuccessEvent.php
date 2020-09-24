<?php

declare(strict_types=1);

namespace App\EventListeners;


use App\User\Infrastructure\Doctrine\Main\Entity\UserEntity;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent as LexikEvent;

class AuthenticationSuccessEvent
{
    /**
     * @param LexikEvent $event
     */
    public
    function onAuthenticationSuccessResponse(LexikEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserEntity) {
            return;
        }

        $data['data'] = array(
            'roles' => $user->getRoles(),
            'userId' => $user->getId()
        );

        $event->setData($data);
    }
}