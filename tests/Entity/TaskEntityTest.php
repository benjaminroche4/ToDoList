<?php


namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskEntityTest extends KernelTestCase
{
    public function testValidEntity(){
        $task = (new Task())
            ->setIsDone(0)
            ->setContent('Ceci est le contenu test')
            ->setTitle('Ceci est le titre test')
            ->setCreatedAt(new \DateTimeImmutable());

        self::bootKernel();
        $error = self::getContainer()->get('validator')->validate($task);
        $this->assertCount(0, $error);
    }

    public function testBadEntity(){
        $task = (new Task())
            ->setIsDone(0)
            ->setContent('')
            ->setTitle('')
            ->setCreatedAt(new \DateTimeImmutable());

        self::bootKernel();
        $error = self::getContainer()->get('validator')->validate($task);
        $this->assertCount(2, $error);
    }
}