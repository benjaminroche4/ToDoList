<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testRegisterPageIsUp(): void
    {
        $client = static::createClient();
        $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Inscrivez-vous');
    }

    public function testRegisterFormIsUp(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $buttonCrawlerMode = $crawler->selectButton('S\'inscrire');

        $form = $buttonCrawlerMode->form([
            'registration_form[email]'=>'email@test.com',
            'registration_form[username]'=>'usernameTest',
            'registration_form[plainPassword]'=>'password',
            'registration_form[roles]'=>'ROLES_USER'
        ]);

        $client->submit($form);

        $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
    }
}
