<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginPageIsUp(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Connectez-vous');
    }

    public function testLoginFormIsUp(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $buttonCrawlerMode = $crawler->selectButton('Connexion');
        $buttonCrawlerMode->form();

        $form = $buttonCrawlerMode->form([
            'email'=>'admin1@admin.com',
            'password'=>'admin'
        ]);

        $client->submit($form);

        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }
}
