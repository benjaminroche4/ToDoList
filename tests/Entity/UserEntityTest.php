<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserEntityTest extends TestCase
{
    public function testIsTrue()
    {
        $user = new User();
        $roles = 'ROLES_USER';

        $user->setUsername('username')
            ->setEmail('email@email.com')
            ->setPassword('password');

        $this->assertTrue($user->getUsername() === 'username');
        $this->assertTrue($user->getEmail() === 'email@email.com');
        $this->assertTrue($user->getPassword() === 'password');
    }

    public function testIsFalse()
    {
        $user = new User();

        $user->setUsername('username')
            ->setEmail('email@email.com')
            ->setPassword('password');

        $this->assertFalse($user->getUsername() === 'false');
        $this->assertFalse($user->getEmail() === 'false');
        $this->assertFalse($user->getPassword() === 'false');
    }

    public function testIsEmpty()
    {
        $user = new User();

        $this->assertEmpty($user->getId());
        $this->assertEmpty($user->getUserIdentifier());
        $this->assertEmpty($user->getSalt());
        $this->assertEmpty($user->eraseCredentials());
        $this->assertEmpty($user->getTasks());
    }

    public function testAddAndRemoveTask(){
        $user = new User();
        $task = new Task();

        $this->assertEmpty($user->getTasks());
        $user->addTask($task);
        $this->assertContains($task, $user->getTasks());

        $user->removeTask($task);
        $this->assertEmpty($user->getTasks());
    }
}
