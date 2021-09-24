<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = $manager->find(User::class, 13);

        for ($i = 0; $i < 10; $i++) {
            $task = new Task();
            $task->setTitle('Titre n°'.$i);
            $task->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do  magna aliqua.');
            $task->setIsDone(false);
            $task->setCreatedAt(new \DateTimeImmutable());
            $task->setUser($user);
            $manager->persist($task);
        }

        $manager->flush();
    }
}