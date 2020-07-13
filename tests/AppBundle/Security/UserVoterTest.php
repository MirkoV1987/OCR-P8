<?php

namespace AppBundle\Tests\Security\Voter;

use AppBundle\Entity\User;
use AppBundle\Security\UserVoter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserVoterTest extends WebTestCase
{
    private $voter;
    private $token;
    private $user;

    public function setUp()
    {
        $this->voter = new UserVoter();
        $this->user = $this->createMock(User::class);
        $this->token = new UsernamePasswordToken($this->user, 'credentials', 'memory');
    }

    public function testUserVoterGet()
    {
        $this->user->method('isAdmin')->willReturn(1);
        $this->assertSame(1, $this->voter->vote($this->token, $this->user, ['GET']));
    }

    public function testUserVoterGetNotAdmin()
    {
        $this->user->method('isAdmin')->willReturn(0);
        $this->assertSame(-1, $this->voter->vote($this->token, $this->user, ['GET']));
    }

    public function testUserVoterGetNoUser()
    {
        $anonToken = new AnonymousToken('secret', 'anonymous');
        $this->assertSame(-1, $this->voter->vote($anonToken, $this->user, ['GET']));
    }

    public function testUserVoterEdit()
    {
        $this->user->method('isAdmin')->willReturn(1);
        $this->assertSame(1, $this->voter->vote($this->token, $this->user, ['EDIT']));
    }

    public function testUserVoterEditNotAdmin()
    {
        $this->user->method('isAdmin')->willReturn(0);
        $this->assertSame(-1, $this->voter->vote($this->token, $this->user, ['EDIT']));
    }

    public function testUserVoterAdd()
    {
        $this->user->method('isAdmin')->willReturn(1);
        $this->assertSame(1, $this->voter->vote($this->token, $this->user, ['ADD']));
    }

    public function testUserVoterAddNotAdmin()
    {
        $this->user->method('isAdmin')->willReturn(0);
        $this->assertSame(-1, $this->voter->vote($this->token, $this->user, ['ADD']));
    }

    public function testUserVoterRemove()
    {
        $this->user->method('isAdmin')->willReturn(1);
        $this->assertSame(1, $this->voter->vote($this->token, $this->user, ['REMOVE']));
    }

    public function testUserVoterRemoveNotAdmin()
    {
        $this->user->method('isAdmin')->willReturn(0);
        $this->assertSame(-1, $this->voter->vote($this->token, $this->user, ['REMOVE']));
    }
}
