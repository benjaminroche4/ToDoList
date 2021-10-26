<?php

namespace App\Tests;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private $objectManager;

    public function testTaskPageIsUp(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin1@admin.com');
        $client->loginUser($testUser);

        $client->request('GET', '/tasks');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Tâches en cours');
    }

    public function testTaskDonePageIsUp(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin1@admin.com');
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/done');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Tâches finies');
    }

    public function testNewTaskIsUp(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin1@admin.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/tasks/add');
        $this->assertSelectorTextContains('h1', 'Ajouter une tâche');

        $buttonCrawlerMode = $crawler->selectButton('Envoyer');

        $form = $buttonCrawlerMode->form([
            'task[title]'=>'Title test',
            'task[content]'=>'Content test'
        ]);

        $client->submit($form);

        $client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();
    }

    public function testUpdateTaskIsUp()
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin1@admin.com');
        $client->loginUser($testUser);

        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $taskRepository = $entityManager->getRepository(Task::class);
        $taskId = $taskRepository->findOneBy(['title'=>'title'])->getId();
        $crawler = $client->request('GET', '/tasks/update/'.$taskId);

        $buttonCrawlerMode = $crawler->selectButton('Modifier');
        $buttonCrawlerMode->form();

        $form = $buttonCrawlerMode->form([
            'update_task[title]'=>'title',
            'update_task[content]'=>'content'
        ]);

        $client->submit($form);

        $client->request('GET', '/tasks/update/'.$taskId);
        $this->assertResponseIsSuccessful();
    }

    public function testToggleTask()
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin1@admin.com');
        $client->loginUser($testUser);

        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $taskRepository = $entityManager->getRepository(Task::class);
        $taskId = $taskRepository->findOneBy(['title'=>'title'])->getId();
        $client->request('GET', '/tasks/toggle/'.$taskId);
        $this->assertResponseRedirects('/tasks');
    }

    public function testDeleteTask()
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin1@admin.com');
        $client->loginUser($testUser);

        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $taskRepository = $entityManager->getRepository(Task::class);
        $taskId = $taskRepository->findOneBy(['title'=>'Titre n°1'])->getId();
        $client->request('GET', '/tasks/delete/'.$taskId);
        $this->assertResponseRedirects('/tasks');
    }
}
