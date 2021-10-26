<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class TaskEntityTest extends TestCase
{
    public function testIsTrue()
    {
        $task = new Task();
        $datetime = new \DateTimeImmutable();

        $task->setTitle('title')
            ->setCreatedAt($datetime)
            ->setIsDone(true)
            ->setContent('contenu');

        $this->assertTrue($task->getTitle() === 'title');
        $this->assertTrue($task->getCreatedAt() === $datetime);
        $this->assertTrue($task->getContent() === 'contenu');
        $this->assertTrue($task->getIsDone() === true);
    }

    public function testIsFalse()
    {
        $task = new Task();
        $datetime = new \DateTimeImmutable();

        $task->setTitle('title')
            ->setCreatedAt($datetime)
            ->setIsDone(true)
            ->setContent('contenu');

        $this->assertFalse($task->getTitle() === 'false');
        $this->assertFalse($task->getCreatedAt() === new \DateTimeImmutable());
        $this->assertFalse($task->getContent() === 'false');
        $this->assertFalse($task->getIsDone() === false);
    }

    public function testIsEmpty()
    {
        $task = new Task();

        $this->assertEmpty($task->getId());
        $this->assertEmpty($task->getUser());
        $this->assertEmpty($task->getIsDone());
        $this->assertEmpty($task->getContent());
        $this->assertEmpty($task->getCreatedAt());
        $this->assertEmpty($task->getTitle());
    }
}
