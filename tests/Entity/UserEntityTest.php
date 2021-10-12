<?php


namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserEntityTest extends KernelTestCase
{
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
}