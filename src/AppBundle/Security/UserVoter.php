<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array('GET', 'ADD', 'EDIT', 'REMOVE'))) {
            return false;
        }

        // only vote on User objects inside this voter
        if (!$subject instanceof UserInterface) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            // the user must be logged in; if not, deny access
            return false;
        }

        $user = $subject;

        if ($attribute === 'ADD' || $attribute === 'GET' || $attribute === 'EDIT' || $attribute === 'REMOVE') {
            if ($user->isAdmin()) {
                return true;
            }
            return false;
        }
    // @codeCoverageIgnoreStart
    }
    // @codeCoverageIgnoreEnd
}
