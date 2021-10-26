<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testAdminPageIsUp()
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin1@admin.com');
        $client->loginUser($testUser);

        $client->request('GET', '/admin');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Panel Admin');
    }

    public function testUpdateUserPageIsUp()
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin1@admin.com');
        $client->loginUser($testUser);

        $userId = $userRepository->findOneBy(['email'=>'4email@email.com'])->getId();
        $crawler = $client->request('GET', '/admin/update/'.$userId);

        $buttonCrawlerMode = $crawler->selectButton('Modifier');
        $buttonCrawlerMode->form();

        $form = $buttonCrawlerMode->form([
            'update_user[username]'=>'username',
            'update_user[email]'=>'4email@email.com'
        ]);

        $client->submit($form);

        $client->request('GET', '/admin/update/'.$userId);
        $this->assertResponseIsSuccessful();
    }

    public function testDeleteUser()
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin1@admin.com');
        $client->loginUser($testUser);

        $userId = $userRepository->findOneBy(['email'=>'email@test.com'])->getId();
        $client->request('GET', '/admin/delete/'.$userId);
        $this->assertResponseRedirects('/admin');
    }
}
