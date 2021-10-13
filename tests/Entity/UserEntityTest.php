<?php


namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserEntityTest extends KernelTestCase
{
    /**
     * Try insert valid entity
     */
    public function testValidEntity(){
        $user = (new User())
            ->setRoles(array('[ROLE_USER]'))
            ->setEmail('userTest@test.com')
            ->setUsername('userTest')
            ->setPassword('userPassword');
        self::bootKernel();

        $error = self::getContainer()->get('validator')->validate($user);
        $this->assertCount(0, $error);
    }

    /**
     * Try insert bad entity
     */
    public function testBadEntity(){
        $user = (new User())
            ->setRoles(array('[ROLE_USER]'))
            ->setEmail('')
            ->setUsername('')
            ->setPassword('password');
        self::bootKernel();

        $error = self::getContainer()->get('validator')->validate($user);
        $this->assertCount(2, $error);
    }

    /**
     * Insert and remove task by user
     */
    public function testAddToRemoveTask(){
        $user = new User();
        $task = new Task();

        $this->assertEmpty($user->getTasks());
        $user->addTask($task);
        $this->assertContains($task, $user->getTasks());

        $user->removeTask($task);
        $this->assertEmpty($user->getTasks());
    }
}