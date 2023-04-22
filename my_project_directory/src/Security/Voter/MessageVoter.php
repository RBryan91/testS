<?php

namespace App\Security\Voter;

use App\Entity\Message;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class MessageVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const DELETE = 'POST_DELETE';

    protected function supports(string $attribute, mixed $message): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $message instanceof \App\Entity\Message;
    }

    protected function voteOnAttribute(string $attribute, mixed $message, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        
        if(null === $message->getUser()) return false;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($message, $user);
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case self::DELETE:
                return $this->canDelete($message, $user);
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
    private function canEdit(Message $message, User $user){
        //le propriétraire de l'annonce peut modifié l'annonce
        return $user === $message->getUser();
    }
    private function canDelete(Message $message, User $user){
        return $user === $message->getUser();
    }
}
