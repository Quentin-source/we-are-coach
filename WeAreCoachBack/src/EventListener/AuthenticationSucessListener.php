<?php

namespace App\EventListener;


use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Entity EventListener
 */
class AuthenticationSuccessListener
{
/**
 * @param AuthenticationSuccessEvent $event
 */
public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
{
    $data = $event->getData();
    $user = $event->getUser();

    if (!$user instanceof UserInterface) {
        return;
    }

    $data['data'] = array(
        'username' => $user->getEmail(),
        'picture' => $user->getPicture(),
        'pseudo' => $user->getPseudo(),
    );

    $event->setData($data);
}
}