<?php


namespace App\Tests\Controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testTaskNotDone(){
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('2email@email.com');
        $client->loginUser($testUser);

        $client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Tâches en cours');
    }

    public function testTaskIsDone(){
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('2email@email.com');
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/done');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Tâches finies');
    }

    public function testNewTask(){
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('2email@email.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/tasks/add');
        $form = $crawler->selectButton('Envoyer')->form([
            'task[title]' => 'Title test',
            'task[content]' => 'Content test'
        ]);
        $client->submit($form);

        $this->assertResponseRedirects('/tasks');
    }

    public function testBadNewTask(){
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('2email@email.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/tasks/add');
        $form = $crawler->selectButton('Envoyer')->form([
            'task[title]' => 'Title test',
            'task[content]' => 'Content test'
        ]);
        $client->submit($form);

        $this->assertResponseRedirects();
        $client->followRedirect();
    }
}